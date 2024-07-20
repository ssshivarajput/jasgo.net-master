<?php
session_start();

abstract class SlimStatus {
    const FAILURE = 'failure';
    const SUCCESS = 'success';
}

class Slim {

    public static function getImages($inputName = 'slim') {

        $values = self::getPostData($inputName);

        // test for errors
        if ($values === false) {
            return false;
        }

        // determine if contains multiple input values, if is singular, put in array
        $data = array();
        if (!is_array($values)) {
            $values = array($values);
        }

        // handle all posted fields
        foreach ($values as $value) {
            $inputValue = self::parseInput($value);
            if ($inputValue) {
                array_push($data, $inputValue);
            }
        }

        // return the data collected from the fields
        return $data;

    }

    // $value should be in JSON format
    private static function parseInput($value) {

        // if no JSON received, exit, don't handle empty input values.
        if (empty($value)) {
            return null;
        }

        // The data is posted as a JSON string so to be used it needs to be deserialized first
        $data = json_decode($value);

        // shortcut
        $input = null;
        $actions = null;
        $output = null;
        $meta = null;

        if (isset($data->input)) {

            $inputData = null;
            if (isset($data->input->image)) {
                $inputData = self::getBase64Data($data->input->image);
            } else if (isset($data->input->field)) {
                $filename = $_FILES[$data->input->field]['tmp_name'];
                if ($filename) {
                    $inputData = file_get_contents($filename);
                }
            }

            $input = array(
                'data' => $inputData,
                'name' => $data->input->name,
                'type' => $data->input->type,
                'size' => $data->input->size,
                'width' => $data->input->width,
                'height' => $data->input->height,
            );

        }

        if (isset($data->output)) {

            $outputData = null;
            if (isset($data->output->image)) {
                $outputData = self::getBase64Data($data->output->image);
            } else if (isset($data->output->field)) {
                $filename = $_FILES[$data->output->field]['tmp_name'];
                if ($filename) {
                    $outputData = file_get_contents($filename);
                }
            }

            $output = array(
                'data' => $outputData,
                'name' => $data->output->name,
                'type' => $data->output->type,
                'width' => $data->output->width,
                'height' => $data->output->height
            );
        }

        if (isset($data->actions)) {
            $actions = array(
                'crop' => isset($data->actions->crop) ? array(
                    'x' => $data->actions->crop->x,
                    'y' => $data->actions->crop->y,
                    'width' => $data->actions->crop->width,
                    'height' => $data->actions->crop->height,
                    'type' => $data->actions->crop->type
                ) : null,
                'size' => isset($data->actions->size) ? array(
                    'width' => $data->actions->size->width,
                    'height' => $data->actions->size->height
                ) : null,
                'rotation' => $data->actions->rotation,
                'filters' => isset($data->actions->filters) ? array(
                    'sharpen' => $data->actions->filters->sharpen
                ) : null
            );
        }

        if (isset($data->meta)) {
            $meta = $data->meta;
        }

        // We've sanitized the base64data and will now return the clean file object
        return array(
            'input' => $input,
            'output' => $output,
            'actions' => $actions,
            'meta' => $meta
        );
    }

    // $path should have trailing slash
    public static function saveFile($data, $name) {
        $id = $_GET['id'];
        $tbl_name = $_GET['table'];
        $column = $_GET['column'];
        $path = __DIR__ . '/../../storageassets/'. $_GET['folder'].'/';

        // Add trailing slash if omitted
        if (substr($path, -1) !== '/') {
            $path .= '/';
        }

        // Ensure directory exists
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        // Sanitize characters in file name
        $name = self::sanitizeFileName($name);

        // Get file extension
        $ext = pathinfo($name, PATHINFO_EXTENSION);

        // Generate unique file name
        $name = date("ymdHis") . '.' . $ext;

        // Add name to path
        $path = $path . $name;

        // Store the file
        self::save($data, $path);

        // Update database record
        include '../config7.php';
        $sqlup = "UPDATE $tbl_name SET $column ='$name' WHERE id='$id'";
        $updateup = mysqli_query($con, $sqlup);

        // Return the file's new name and location
        return array(
            'name' => $name,
            'path' => $path
        );
    }

    // Get data from remote URL
    public static function fetchURL($url, $maxFileSize) {
        if (!ini_get('allow_url_fopen')) {
            return null;
        }
        $content = null;
        try {
            $content = @file_get_contents($url, false, null, 0, $maxFileSize);
        } catch (Exception $e) {
            return false;
        }
        return $content;
    }

    // Output data as JSON
    public static function outputJSON($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    // Remove characters which aren't a word, whitespace, number, or any of the following characters: -_~,;[]().
    private static function sanitizeFileName($str) {
        // Basic clean up
        $str = preg_replace('([^\w\s\d\-_~,;\[\]\(\).])', '', $str);
        // Remove any runs of periods
        $str = preg_replace('([\.]{2,})', '', $str);
        return $str;
    }

    // Get the posted data from the POST or FILES object. If using Slim to upload, it will be in POST (posted with hidden field). If not enhanced with Slim, it'll be in FILES.
    private static function getPostData($inputName) {
        $values = array();
        if (isset($_POST[$inputName])) {
            $values = $_POST[$inputName];
        } else if (isset($_FILES[$inputName])) {
            // Slim was not used to upload this file
            return false;
        }
        return $values;
    }

    // Save the data to a given location
    private static function save($data, $path) {
        return file_put_contents($path, $data) !== false;
    }

    // Strips the "data:image..." part of the base64 data string so PHP can save the string as a file
    private static function getBase64Data($data) {
        return base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
    }
}

