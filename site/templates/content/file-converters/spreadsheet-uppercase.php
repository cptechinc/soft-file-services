<?php 
    if ($input->requestMethod('POST')) {
        $fileuploader = new Dplus\FileServices\FileUploader();
        $uploaded = $fileuploader->upload($_FILES, $input->post->text('filename'));
        
        
        if ($uploaded) {
            $spreadsheetwriter = new Dplus\FileServices\SpreadSheetWriter();
            $spreadsheetwriter->convert_filetouppercase($fileuploader->file, $input->post->text('file-extension'));
            
            if (file_exists($spreadsheetwriter->outputfile->get_filepath())) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename='.basename($spreadsheetwriter->outputfile->get_filepath()));
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Pragma: public');
                header('Content-Length: ' . filesize($spreadsheetwriter->outputfile->get_filepath()));
                ob_clean();
                flush();
                readfile($spreadsheetwriter->outputfile->get_filepath());
                exit;
            } 
        } else {
            echo implode("<br>", $fileuploader->errors);
        }
    } else {
        $page->body = $config->paths->content."file-uploader/form.php";
        include ($config->paths->templates.'_include-page.php');
    }
