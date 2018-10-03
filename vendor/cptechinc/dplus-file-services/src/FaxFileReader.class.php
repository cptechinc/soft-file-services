<?php
    /**
     * Class that will process and convert the fax file and parse the data from the file
     */
    class FaxFileReader {
        
        /**
         * Fax File Path
         * @var string
         */
        protected $faxfile;
        
        /**
         * File Contents
         * @var string
         */
        protected $file;
        /* =============================================================
			EXAMPLE OF FILE CONTENTS
            ------------------------------------------------------------
            sub=Quote Nbr: W0000004
            fll=csf87649.pcl
            res=fine
            fnm=Bev Gruhlke
            fco=C & P TECHNOLOGIES INC.
            fvn=952-888-1888
            ffn=952-888-1813
            stm=now
            not=both
            mad=paul@cptechinc.com
            tfn=9528881813
            tnm=Bev
            tco=
            tvn=000-000-0000
            que=fax1
		============================================================ */
        
        /**
         * Converts file into an array for each line an array element
         * // NOTE It converts the file from looking like the example above
         * // EXAMPLE ['sub=Quote Nbr: W0000004', 'fll=csf87649.pcl']
         * @param  string $file File Contents
         * @return array        File as key-value array
         */
        public function get_faxfile($file) {
            $this->faxfile = $file;
            
            if (file_exists($this->faxfile)) {
                $this->file = file_get_contents($this->faxfile);
                
                if ($this->file) {
                    return $this->convert_filelinearraytokeyvalue(explode("\n", str_replace("\r", '', $this->file)));
                } else {
                    $error = error_get_last();
                    $this->error($error['message']);
                    return false;
                }
            } else {
                $this->error("Could not find file $this->faxfile");
                return false;
            }
        }
        
        /**
         * Converts Array that each element is one line of the file into a Key-Value Array
         * // EXAMPLE OF ARRAY ELEMENT sub=Quote Nbr: W0000004
         * @param  array $linearray  Array of Line data
         * @return array             Key Value array
         */
        protected function convert_filelinearraytokeyvalue($linearray) {
            $filedata = array();
            foreach ($linearray as $line) {
                $subarray = explode('=', $line);
                $key = $linearray[0];
                $value = $linearray[1];
                $filedata[$key] = $value;
            }
            return $filedata;
        }
        
        /**
         * 
         * @param  string $file    Full Path to file
         * @param  array  $faxdata Array for fax data to get values for
         * @return array           Faxer Fax Data
         */
        public function process($file, array $faxdata) {
            $filearray = $this->get_faxfile($file);
            return $this->convert_fileforfaxer($filearray, $faxdata);
        }
        
        /**
         * Converts the File Array, converts each element in the array into an array
         * @param  array  $filearray Key Value array from file
         * @param  array  $faxdata   Fax Data to populate / overwrite
         * @return array             Fax Data with File Values
         */
        protected function convert_fileforfaxer(array $filearray, array $faxdata) {
            foreach ($filearray as $key => $value) {
                if (array_key_exists($key, $faxdata)) {
                    $faxdata[$key] = $value;
                }
            }
            return $faxdata;
        }
    }
