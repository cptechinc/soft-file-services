<?php
    /**
     * Class for containing Properties about a file or a theoretical file
     */
    class UploadedFile {
        use ThrowErrorTrait;
		use MagicMethodTraits;
        use CreateFromObjectArrayTraits;
        
        /**
         * File's original name
         * @var string
         */
        protected $originalname;
        
        /**
         * File Name with extension
         * @var string
         */
        protected $name;
        
        /**
         * File Size
         * @var int
         */
        protected $size;
        
        /**
         * File's Temp Name
         * @var string
         */
        protected $tmpname;
        
        /**
         * File's Extension
         * @var string
         */
        protected $extension;
        
        /**
         * File MIME Type
         * @var string
         */
        protected $type;
        
        /**
         * Directory in which file exists
         * @var string
         */
        protected $directory;
        
        /**
         * Instantiates an Instance from array, specifically meant to be used for the $_FILES array
         * @param  array        $files $_FILES array
         * @param  string       $input Input name
         * @return UploadedFile        New instance of UploadedFile
         */
        public static function create_fromfilesarray($files, $input = 'file') {
            $file = new UploadedFile();
            $file->set('originalname', $files[$input]['name']);
            $file->set('name', $files[$input]['name']);
            $file->set('size', $files[$input]['size']);
            $file->set('tmpname', $files[$input]['tmp_name']);
            $file->set('type', $files[$input]['type']);
            $file->set('extension', strtolower(end(explode('.', $file->name))));
            return $file;
        }
        
        /**
         * Sets new File Extension, also changes it on the file name
         * @param string $extension File Extension
         */
        public function set_extension($extension) {
            $oldextension = $this->extension;
            $this->extension = $extension;
            $this->name = str_replace(".$oldextension", ".$extension", $this->name);
        }
        
        /**
         * Returns File Path for file by concatenating $this->directory and $this->name
         * @return string Full File Path
         */
        public function get_filepath() {
            $this->directory = empty($this->directory) ? DplusWire::wire('config')->documentstoragedirectory : $this->directory;
            return $this->directory.$this->name;
        }
    }
