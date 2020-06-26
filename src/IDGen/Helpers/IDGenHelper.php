<?php

namespace AndrykVP\SWC\IDGen\Helpers;

use Illuminate\Support\Facades\Storage;

class IDGenHelper
{ 
    protected static $templates, $images, $display;

    /**
     * Construct the class from configuration variables
     * 
     * @return void
     */
    public function __construct()
    {
        self::$templates = json_decode(json_encode(config('idgen.templates')));
        self::$images = (object) [
            'avatar' => json_decode(json_encode(config('idgen.avatar'))),
            'signature' => json_decode(json_encode(config('idgen.signature'))),
        ];
        self::$display = (object) [
            'colors' => json_decode(json_encode(config('idgen.colors'))),
            'fonts' => json_decode(json_encode(config('idgen.fonts'))),
        ];
    }

    /**
     * Verify if the resource image exists
     * 
     * @return mixed
     */
    private static function getResource($id, $template, $type)
    {
        if(Storage::disk('idgen')->missing(self::$templates->{$template}->input . '/' . $type . '/' . $id . '.png'))
        {
            return null;
        }

        return storage_path(self::getTemplateUrl($template, 'input') . $type . '/' . $id . '.png');

    }

    /**
     * Replace unwanted characters from User name for usage as filename
     * 
     * @return string
     */
    private static function stringName($name)
    {
        return preg_replace(['/(\s+)/','/(\'+)/','/(\`+)/','/(\´+)/'],'',$name);
    }
    
    /**
     * Get the template url
     * 
     * @return string
     */
    private static function getTemplateUrl($template, $dir)
    {
        return 'idgen/'.self::$templates->{$template}->{$dir} . '/';
    }

    /**
     * Funtion to process request to build avatars
     *
     * @return void
     */
    public static function makeAvatar($user, $template)
    {
        $resource = self::getResource($user->id,$template,'avatar');

        if($resource === null)
        {
            return null;
        }

        $filename = self::stringName($user->name);
        $input = self::getTemplateUrl($template, 'input').'templates/';
        $output = self::getTemplateUrl($template, 'output').'avatars/';

        return self::generateAvatars($resource, $input, $output, $filename, $user);
    }

    /**
     * Funtion to process request to build signature
     *
     * @return void
     */
    public static function makeSignature($user)
    {
        $resource = self::getResource($user->id,'signature');

        if($resource != null)
        {
            // Trigger alert event if source file cannot be found
            return false;
        }

        $filename = self::stringName($user->name);
        $url = self::getTemplateUrl('default').'templates';
        
        //return self::generateSignature($filename, $user->name, $user->rank, $faction, $faction_logo, $resource, $user->email, $user->department);
    }

    /**
     * Create Signature ID based on the existing files
     */
    private static function generateSignature($filename, $name, $rank, $faction, $faction_logo, $resource, $email = null, $department = null)
    {
        try
        {
            $base = imagecreatefrompng(self::$signature->template->background);
            $frame = imagecreatefrompng(self::$signature->template->frame);
            $logo = imagecreatefrompng($faction_logo);
            $tempavi = imagecreatefrompng($resource);
            $avatar = imagecreatetruecolor(122,122);
            imagecopyresampled($avatar,$tempavi,0,0,0,0,122,122,122,122);
            imagealphablending($base, true);
            imagesavealpha($base, true);
            imagealphablending($avatar, true);
            imagesavealpha($avatar, true);
            imagealphablending($frame, true);
            imagesavealpha($frame, true);
            imagealphablending($logo, true);
            imagesavealpha($logo, true);

            imagecopy($avatar,$frame,0,0,0,0,122,122);
            imagecopy($base,$avatar,30,35,0,0,122,122);
            imagecopy($base,$logo,440,84,0,0,78,76);

            imagedestroy($frame);
            imagedestroy($logo);
            imagedestroy($avatar);
            imagedestroy($tempavi);

            $white = imagecolorallocate($base, 0xFF, 0xFF, 0xFF);
            $grey = imagecolorallocate($base, 0xA7, 0xA7, 0xA7);

            $namesize = imageftbbox(28,0,$fonts["sans"],$name);
            $nameposition = 320 - ($namesize[4] / 2);
            imagefttext($base,28,0,$nameposition,67,$white,$fonts->sans,$name);
            imagefttext($base,7,0,198,99,$grey,$fonts->serif,"MINISTRY:");
            imagefttext($base,7,0,255,99,$white,$fonts->serif,strtoupper($department));
            imagefttext($base,7,0,214,117,$grey,$fonts->serif,"RANK:");
            imagefttext($base,7,0,255,117,$white,$fonts->serif,strtoupper($rank));
            imagefttext($base,7,0,202,135,$grey,$fonts->serif,"FACTION:");
            imagefttext($base,7,0,255,135,$white,$fonts->serif,strtoupper($faction));

            if($data['email_display'] != 0)
            {
                imagefttext($base,7,0,213,153,$grey,$fonts->serif,"EMAIL:");
                imagefttext($base,7,0,255,153,$white,$fonts->serif,$email);
            }

            $file = storage_path("app/public/ids/".$filename."Sig.png");
            imagepng($base, $file);
            imagedestroy($base);
        }
        catch (Exception $e)
        {
            return response($e->getMessage(),500);
        }
    }

    /**
     * Create Avatar IDs based on the existing files
     * 
     * @param string //$resource, $url, $filename
     * @param object //$user
     * 
     * @return void
     */
    public static function generateAvatars($resource, $input, $output, $filename, $user)
    {
        // Generate Avatars
        $lgavatar = imagecreatetruecolor(self::$images->avatar->large->dimensions,self::$images->avatar->large->dimensions);
        $smavatar = imagecreatetruecolor(self::$images->avatar->small->dimensions,self::$images->avatar->small->dimensions);
        self::imageAvatarSample($lgavatar, $resource, $input.self::$images->avatar->large->background, $input.self::$images->avatar->large->frame , $input.self::$images->avatar->large->mask, self::$images->avatar->large->dimensions);
        self::imageAvatarSample($smavatar, $resource, $input.self::$images->avatar->small->background, $input.self::$images->avatar->small->frame , $input.self::$images->avatar->small->mask, self::$images->avatar->small->dimensions);

        // Build colors from configuration
        $lgcolors = self::assignColors($lgavatar);
        $smcolors = self::assignColors($smavatar);

        //Add Text
        if(self::$images->avatar->large->handle->display)
        {
            self::buildText($lgavatar, $lgcolors['primary'], $lgcolors['black'], $user->name, self::$fonts->sans, self::$images->avatar->large->handle->size, self::$images->avatar->large->handle->position, self::$images->avatar->large->handle->angle);
        }
        if(self::$images->avatar->large->rank->display)
        {
            self::buildText($lgavatar, $lgcolors['muted'], $lgcolors['black'], $user->rank->name, self::$fonts->sans, self::$images->avatar->large->rank->size, self::$images->avatar->large->rank->position, self::$images->avatar->large->rank->angle);
        }
        if(self::$images->avatar->small->handle->display)
        {
            self::buildText($smavatar, $smcolors['primary'], $smcolors['black'], $user->name, self::$fonts->sans, self::$images->avatar->small->handle->size, self::$images->avatar->small->handle->position, self::$images->avatar->small->handle->angle);
        }

        // Store generated image
        self::storeImage($lgavatar, $output, $filename, self::$images->avatar->sufix.self::$images->avatar->large->dimensions);
        self::storeImage($smavatar, $output, $filename, self::$images->avatar->sufix.self::$images->avatar->small->dimensions);
    }

    /**
     * Create Avatar Image by merging image files
     * 
     * @param imagelink     // &$image
     * @param string        // $resource, $background, $frame, $mask
     * @param int           // $dimension
     * 
     * @return void
     */
    private static function imageAvatarSample(&$image, $resource, $background, $frame, $mask, $dimension)
    {
        // Get the original dimensions of the images
        list($bg_width, $bg_height) = getimagesize($background);
        list($res_width, $res_height) = getimagesize($resource);
        list($frm_width, $frm_height) = getimagesize($frame);

        // Create images from their URL
        $background = imagecreatefrompng($background);
        $resource = imagecreatefrompng($resource);
        $frame = imagecreatefrompng($frame);
        imagealphablending($background, true);
        imagesavealpha($background, true);
        imagealphablending($resource, true);
        imagesavealpha($resource, true);
        imagealphablending($frame, true);
        imagesavealpha($frame, true);

        // Apply mask if template provides one
        if($mask !== null)
        {
            $maskImg = imagecreatefrompng($mask);
            self::imagealphamask($image,$maskImg);

            imagedestroy($maskImg);
        }

        // Unify images into a single one
        imagecopyresampled($image, $background, 0, 0, 0, 0, $dimension, $dimension, $bg_width, $bg_height);
        imagecopyresampled($image, $resource, 0, 0, 0, 0, $dimension, $dimension, $res_width, $res_height);
        imagecopyresampled($image, $frame, 0, 0, 0, 0, $dimension, $dimension, $frm_width, $frm_height);

        // Destroy unused images to save memory
        imagedestroy($background);
        imagedestroy($resource);
        imagedestroy($frame);
    }

    /**
     * Allocate colors to image link from configuration variables
     * 
     * @param imagelink     // &$image
     * 
     * @return void
     */
    private static function assignColors(&$image)
    {
        // Turn hexadecimal string to rgb values
        $primary = self::parseColor(self::$colors->primary);
        $accent = self::parseColor(self::$colors->accent);
        $muted = self::parseColor(self::$colors->muted);

        $colors = [
            'primary' => imagecolorallocate($image, $primary[0], $primary[1], $primary[2]),
            'accent' => imagecolorallocate($image, $accent[0], $accent[1], $accent[2]),
            'muted' => imagecolorallocate($image, $muted[0], $muted[1], $muted[2]),
            'black' => imagecolorallocate($image, 0, 0, 0),
        ];

        return $colors;
    }

    /**
     * Parse Color string to RGB values
     * 
     * @param string
     * @return array
     */
    private static function parseColor($string)
    {
        $color = str_replace('#', '', $string);
        $color = str_replace(' ', '', $color);
        if(strlen($color) < 6)
        {
            $color = $color . $color;
        }

        $color = str_split( $color, 2 );
        
        $color = [
            hexdec($color[0]),
            hexdec($color[1]),
            hexdec($color[2]),
        ];

        return $color;
    }

    /**
     * Creates text and adds it to the image
     */
    private static function buildText(&$image, $color, $black, $text, $font, $size, $position, $angle)
    {
        // Transform position string, into x and y variables
        list($x, $y) = explode(',', $position);
        $x = (int) $x;
        $y = (int) $y;

        // Generate text with outline
        imagefttext($image, $size, $angle, $x, $y, $colors, $font, strtoupper($text));
        imagefttext($image, $size, $angle, $x+1, $y+1, $black, $font, strtoupper($text));
        imagefttext($image, $size, $angle, $x+1, $y-1, $black, $font, strtoupper($text));
        imagefttext($image, $size, $angle, $x-1, $y+1, $black, $font, strtoupper($text));
        imagefttext($image, $size, $angle, $x-1, $y-1, $black, $font, strtoupper($text));
    }

    /**
     * Apply mask to given image link
     * 
     * @param imagelink     // &$picture
     * @param string        // $mask
     * 
     * @return void
     */
    private static function imagealphamask(&$picture, $mask)
    {
        // Get sizes and set up new picture
        $xSize = imagesx( $picture );
        $ySize = imagesy( $picture );
        $newPicture = imagecreatetruecolor( $xSize, $ySize );
        imagesavealpha( $newPicture, true );
        imagefill( $newPicture, 0, 0, imagecolorallocatealpha( $newPicture, 0, 0, 0, 127 ) );

        // Resize mask if necessary
        if( $xSize != imagesx( $mask ) || $ySize != imagesy( $mask ) )
        {
            $tempPic = imagecreatetruecolor( $xSize, $ySize );
            imagecopyresampled( $tempPic, $mask, 0, 0, 0, 0, $xSize, $ySize, imagesx( $mask ), imagesy( $mask ) );
            imagedestroy( $mask );
            $mask = $tempPic;
        }

        // Perform pixel-based alpha map application
        for( $x = 0; $x < $xSize; $x++ )
        {
            for( $y = 0; $y < $ySize; $y++ )
            {
                $alpha = imagecolorsforindex( $mask, imagecolorat( $mask, $x, $y ) );
                $color = imagecolorsforindex( $picture, imagecolorat( $picture, $x, $y ) );
                $alpha = 127 - floor((127-$color['alpha']) * ($alpha[ 'red' ]/255));
                imagesetpixel( $newPicture, $x, $y, imagecolorallocatealpha( $newPicture, $color[ 'red' ], $color[ 'green' ], $color[ 'blue' ], $alpha ) );
            }
        }
        // Copy back to original picture
        imagedestroy( $picture );
        $picture = $newPicture;
    }

    /**
     * Save image to Storage path
     */
    private static function storeImage(&$image, $url, $filename, $sufix)
    {
        $url = storage_path($url . $filename . $sufix . '.png');

        imagepng($image, $url);
        imagedestroy($image);
    }
}