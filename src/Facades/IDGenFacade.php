<?php

namespace AndrykVP\SWC\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Storage;

class IDGenFacade extends Facade
{ 
    /**
     * Construct the class from configuration variables
     */
    protected static $idconf = [], $folder;

    public static function init()
    {
        self::$idconf['avatar'] = config('idgen.avatar');
        self::$idconf['signature'] = config('idgen.signature');
        self::$folder = config('idgen.output');
    }

    /**
     * Verify if ID is buildable. Must have "handle" and "rank_id" columns filled.
     *
     * @var boolean
     */
    private static function verifyInformation($user)
    {
        if($user->handle != null && $user->rank_id != null)
        {
            return true;
        }
        return false;
    }

    /**
     * Verify if the resource image exists
     * 
     * @return mixed
     */
    private static function checkResource($id, $type)
    {
        if (!Storage::exists('private/id_images/'.$id.self::$idconf[$type]->suffix.'.png'))
        {
            return null;
        }

        return storage_path('app/private/id_images/'.$id.self::$idconf[$type]->suffix.'.png');
    }

    /**
     * Replace unwanted characters from User Handle for usage as filename
     */
    private static function stringHandle($handle)
    {
        return preg_replace(['/(\s+)/','/(\'+)/','/(\`+)/','/(\´+)/'],'',$handle);
    }

    /**
     * Funtion to process request to build avatars
     *
     * @return void
     */
    public static function makeAvatar($user)
    {
        $resource = self::checkResource($user->id,'avatar');

        if($resource === null)
        {
            // Trigger alert event if source file cannot be found
            return false;
        }

        $filename = self::stringHandle($user->handle);
        self::generateAvatars($filename, $user->handle, $user->rank, $user->faction, $faction_logo, $resource, $user->email, $user->department);
    }

    /**
     * Funtion to process request to build signature
     *
     * @return void
     */
    public static function makeSignature($user)
    {
        $resource = self::checkResource($user->id,'signature');

        if($resource != null)
        {
            // Trigger alert event if source file cannot be found
            return false;
        }

        $filename = self::stringHandle($user->handle);
        return self::generateSignature($filename, $user->handle, $user->rank, $faction, $faction_logo, $resource, $user->email, $user->department);
    }

    /**
     * Atempts to create Signature ID based on the existing files
     */
    private static function generateSignature($filename, $handle, $rank, $faction, $faction_logo, $resource, $email = null, $department = null)
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

            $handlesize = imageftbbox(28,0,$fonts["sans"],$handle);
            $handleposition = 320 - ($handlesize[4] / 2);
            imagefttext($base,28,0,$handleposition,67,$white,$fonts->sans,$handle);
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
     * Atempts to create Avatar IDs based on the existing files
     */
    public function generateAvatars($filename, $handle, $resource)
    {
        try
        {
            $lgframe = imagecreatefrompng(self::$avatar->templates->large->background);
            $smframe = imagecreatefrompng(self::$avatar->templates->small->background);
            $tempavi = imagecreatefrompng($resource);
            $lgavatar = imagecreatetruecolor(150,150);
            $smavatar = imagecreatetruecolor(100,100);
            $lgmask = imagecreatefrompng(self::$avatar->templates->large->mask);
            $smmask = imagecreatefrompng(self::$avatar->templates->small->mask);
            imagecopyresampled($lgavatar,$tempavi,0,0,-28,0,150,150,150,150);
            imagecopyresampled($smavatar,$tempavi,0,0,-28,0,100,100,150,150);
            self::imagealphamask($lgavatar,$lgmask);
            self::imagealphamask($smavatar,$smmask);
            imagealphablending($lgframe, true);
            imagesavealpha($lgframe, true);
            imagealphablending($smframe, true);
            imagesavealpha($smframe, true);
            imagealphablending($lgavatar, true);
            imagesavealpha($lgavatar, true);
            imagealphablending($smavatar, true);
            imagesavealpha($smavatar, true);

            imagecopy($lgavatar,$lgframe,0,0,0,0,150,150);
            imagecopy($smavatar,$smframe,0,0,0,0,100,100);

            imagedestroy($lgframe);
            imagedestroy($smframe);
            imagedestroy($tempavi);

            $white = imagecolorallocate($lgavatar, 0xFF, 0xFF, 0xFF);
            $black = imagecolorallocate($lgavatar, 0x00, 0x00, 0x00);

            imagefttext($lgavatar,6,0,33,132,$black,$fonts["serif"],strtoupper($rank));
            imagefttext($lgavatar,6,0,33,143,$black,$fonts["serif"],strtoupper($handle));
            imagefttext($lgavatar,6,0,33,134,$black,$fonts["serif"],strtoupper($rank));
            imagefttext($lgavatar,6,0,33,145,$black,$fonts["serif"],strtoupper($handle));
            imagefttext($lgavatar,6,0,35,132,$black,$fonts["serif"],strtoupper($rank));
            imagefttext($lgavatar,6,0,35,143,$black,$fonts["serif"],strtoupper($handle));
            imagefttext($lgavatar,6,0,35,134,$black,$fonts["serif"],strtoupper($rank));
            imagefttext($lgavatar,6,0,35,145,$black,$fonts["serif"],strtoupper($handle));
            imagefttext($lgavatar,6,0,34,133,$white,$fonts["serif"],strtoupper($rank));
            imagefttext($lgavatar,6,0,34,144,$white,$fonts["serif"],strtoupper($handle));

            $smfile = storage_path("app/public/ids/".$filename."SmAvi.png");
            $lgfile = storage_path("app/public/ids/".$filename."LgAvi.png");

            imagepng($smavatar, $smfile);
            imagepng($lgavatar, $lgfile);
            imagedestroy($smavatar);
            imagedestroy($lgavatar);
        }
        catch (Exception $e)
        {
            return response($e->getMessage(),500);
        }
    }

    /**
     * Applies mask
     */

    private static function imagealphamask( &$picture, $mask )
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
}