<?php
namespace PHP\File;
class Upload {
    protected $uploaded = [];
    protected $destination;
/*---- Size is in Bytes-----
Bytes      | MegaBytes (MB)
-----------|----------------
50,000       0.05
100,000      0.1
500,000      0.5
1,000,000    1 
10,000,000   10
50,000,000   50
---------------------------*/

    protected $max = 1000000;  // 1 MB  Default
    protected $messages = [];
    protected $allowed = [
        'image/gif',
        'image/jpeg',
        'image/pjpeg',
        'image/png'
    ];
    protected $typeCheckingOn = true;
    protected $notTrusted = ['bin', 'cgi', 'exe', 'js', 'pl', 'php', 'py', 'sh'];
    protected $newName;
    protected $renameDuplicates = true;

/*===============================================================
        CONSTRUCTOR
/*=============================================================*/    
    public function __construct($path) {
        if (!is_dir($path) || !is_writable($path)) {
            throw new \Exception("$path must be a valid, writable directory.");
        }
        $this->destination = $path;
    }


/*===============================================================
    UPLOAD
/*=============================================================*/
    public function uploadFile( ) {
        $uploaded = current($_FILES);

        if (is_array($uploaded['name'])) {

            foreach ($uploaded['name'] as $key => $value) {
                $currentFile['name']     = $uploaded['name'][$key];
                $currentFile['type']     = $uploaded['type'][$key];
                $currentFile['tmp_name'] = $uploaded['tmp_name'][$key];
                $currentFile['error']    = $uploaded['error'][$key];
                $currentFile['size']     = $uploaded['size'][$key];

                /* print each file info
                echo '<pre>'; 
                print_r($currentFile) ;
                echo '</pre>';
                echo '<br>' ;
                */
                
                if ( $this->checkFile($currentFile) ) {
                     $this->moveFile($currentFile);  
                }
            }
        } 

    }

/*===============================================================
     CHECK FILE
 /*=============================================================*/ 
    protected function checkFile($file) {
        $accept = true;
        if ($file['error'] != 0) {
            $this->getFileErrorMessage($file);

            // stop checking if no file submitted, ERROR = 4
            if ($file['error'] == 4) {
                return false;
            } else {
                $accept = false;
            }
        }
        if (!$this->checkFileSize($file)) {
            $accept = false;
        }
        if ($this->typeCheckingOn) {
            if (!$this->checkType($file)) {
                $accept = false;
            }
        }
        if ($accept) {
            $this->checkName($file);
        }
        return $accept;
    }

/*===============================================================
    MOVE FILE
/*=============================================================*/
    protected function moveFile($file) {
        // at this point $this->newName is not null
        $filename = isset($this->newName) ? $this->newName : $file['name'];
        $success = move_uploaded_file($file['tmp_name'], $this->destination . $filename);
        if ($success) {
            $result = $file['name'] . ' was uploaded successfully';
            // 
            if (!is_null($this->newName)) {
                $result .= ', and was renamed ' . $this->newName;
            }
            $this->messages[] = $result;
        } else {
            $this->messages[] = 'Could not upload ' . $file['name'];
        }
    }

/*===============================================================
    CHECK NAME
/*=============================================================*/
    protected function checkName($file) {
        $this->newName = null;
        $nospaces = str_replace(' ', '_', $file['name'] );
        if ($nospaces != $file['name']) {
            $this->newName = $nospaces;
        }

        $name = isset($this->newName) ? $this->newName : $file['name'];
        $existing = scandir($this->destination);
        // this file exists already, rename it
        if (in_array($name, $existing)) {
            $basename = pathinfo($name, PATHINFO_FILENAME);
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $i = 1;
 
            do {
                $this->newName = $basename . '_' . $i++;
                if (!empty($extension)) {
                    $this->newName .= ".$extension"; 
                }

            } while (in_array($this->newName, $existing));
        }
    
    }

/*===============================================================
        GET MESSAGES
/*=============================================================*/    
    public function getMessages() {
        return $this->messages;
    }

/*===============================================================
        GET MAXSIZE
/*=============================================================*/     
    public function getMaxSize() {
        return number_format($this->max/1024, 1) . ' KB';
    }

/*===============================================================
    GET ERROR MESSAGE   
/*=============================================================*/    
    protected function getFileErrorMessage($file) {
        switch($file['error']) {
            case 1:
            case 2:
                $this->messages[] = $file['name'] . ' is too big: (max: ' .
                    $this->getMaxSize() . ').';
                break;
            case 3:
                $this->messages[] = $file['name'] . ' was only partially uploaded.';
                break;
            case 4:
                $this->messages[] = 'No file submitted.';
                break;
            default:
                $this->messages[] = 'Sorry, there was a problem uploading ' . $file['name'];
                break;
        }
    }

/*===============================================================
    CHECK SIZE
/*=============================================================*/
    protected function checkFileSize($file) {
        if ($file['error'] == 1 || $file['error'] == 2) {
            return false;
        } elseif ($file['size'] == 0) {
            $this->messages[] = $file['name'] . ' is an empty file.';
            return false;
            // this will execute for our max size that we specify in this 
            // class, overriding the system php.ini file size 
        } elseif ($file['size'] > $this->max) {
            $this->messages[] = $file['name'] . ' exceeds the maximum size
                for a file (' . $this->getMaxSize() . ').';
            return false;
        } else {
            return true;
        }
    }

/*===============================================================
    CHECK TYPE
/*=============================================================*/
    protected function checkType($file) {
        if (in_array( $file['type'], $this->allowed)) {
            return true;
        } else {
            if (!empty($file['type'])) {
                $this->messages[] = $file['name'] . ' is not permitted type of file.';
            }
            return false;
        }
    }

} // END CLASS
