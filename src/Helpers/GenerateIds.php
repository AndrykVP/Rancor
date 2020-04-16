<?php

namespace CasWaryn\IDGen\Helpers;

class GenerateIds
{ 
    /**
     * Construct the class from configuration variables
     */
    private $avatar, $signature, $folder;

    public function __construct()
    {
        $this->avatar = config('idgen.avatar');
        $this->signature = config('idgen.signature');
        $this->folder = config('idgen.output');
    }

    /**
     * Verify if ID is buildable. Must have "handle" and "rank_id" columns filled.
     *
     * @var boolean
     */
    public function verifyInformation($user)
    {
        if($user->handle != null && $user->rank_id != null)
        {
            return true;
        }
        return false;
    }

    /**
     * Funtion to build the avatar images
     *
     * @return void
     */
    public function makeAvatar($user)
    {
        $resource = $this->checkResource($user->id);

        if($resource === null)
        {
            // Trigger alert event if source file cannot be found
            return false;
        }

        $filename = preg_replace(['/(\s+)/','/(\'+)/','/(\`+)/','/(\´+)/'],'',$user->handle);
        $this->generateAvatars($filename, $user->handle, $user->rank, $user->faction, $faction_logo, $resource, $user->email, $user->department);
    }

    /**
     * Funtion to build the signature images
     *
     * @return void
     */
    public function makeSignature($user)
    {
        $resource = $this->checkResource($user->id);

        if($resource != null)
        {
            // Trigger alert event if source file cannot be found
            return false;
        }

        $filename = preg_replace(['/(\s+)/','/(\'+)/','/(\`+)/','/(\´+)/'],'',$user->handle);
        return $this->generateSignature($filename, $user->handle, $user->rank, $faction, $faction_logo, $resource, $user->email, $department);
    }

    /**
     * Verifies if the resource image exists
     * 
     * @return mixed
     */
    private function checkResource($id)
    {
        if (!Storage::exists('private/id_images/'.$id.'_sig.png'))
        {
            return null;
        }

        return storage_path("app/private/id_images/".$id."_sig.png");
    }

    /**
     * Atempts to create Signature ID based on the existing files
     */
    private function generateSignature($filename, $handle, $rank, $faction, $faction_logo, $resource, $email = null, $department = null)
    {
        try
        {
            $base = imagecreatefrompng($this->signature->template->background);
            $frame = imagecreatefrompng($this->signature->template->frame);
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
            $lgframe = imagecreatefrompng($this->avatar->templates->large->background);
            $smframe = imagecreatefrompng($this->avatar->templates->small->background);
            $tempavi = imagecreatefrompng($resource);
            $lgavatar = imagecreatetruecolor(150,150);
            $smavatar = imagecreatetruecolor(100,100);
            $lgmask = imagecreatefrompng($this->avatar->templates->large->mask);
            $smmask = imagecreatefrompng($this->avatar->templates->small->mask);
            imagecopyresampled($lgavatar,$tempavi,0,0,-28,0,150,150,150,150);
            imagecopyresampled($smavatar,$tempavi,0,0,-28,0,100,100,150,150);
            $this->imagealphamask($lgavatar,$lgmask);
            $this->imagealphamask($smavatar,$smmask);
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

    private function imagealphamask( &$picture, $mask )
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