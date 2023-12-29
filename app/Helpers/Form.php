<?php
namespace App\Helpers;

class Form {
    public static function show ($elements) {
        $xhtml  = null;
        foreach ($elements as $element) {
            $xhtml  .= self::formGroup($element);
        };
        return $xhtml;
    }

    public static function formGroup ($element, $arrParam = null) {
        $type = isset($element['type']) ? $element['type'] : 'text';
        $xhtml = null;

        switch ($type) {
            case 'text':
                $xhtml  .= sprintf('<div class="form-group">
                                        %s
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            %s
                                        </div>
                                    </div>', $element['label'], $element['element']);
                break;
            case 'thumb':
                $xhtml  .= sprintf('<div class="form-group">
                                        %s
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            %s
                                            <p style="margin-top: 50px;">%s</p>
                                        </div>
                                    </div>', $element['label'], $element['element'], $element['thumb']);
                break;
            case 'dropzone':
                $xhtml  .= sprintf('<div class="form-group">
                                        %s
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="dropzone" id="dropzone"></div>
                                        </div>
                                    </div>', $element['label']);
                break;
            case 'avatar':
                $xhtml  .= sprintf('<div class="form-group">
                                        %s
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            %s
                                            <p style="margin-top: 50px;">%s</p>
                                        </div>
                                    </div>', $element['label'], $element['element'], $element['avatar']);
                break;
            case 'btn-submit':
                $xhtml  .= sprintf('<div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                                            %s
                                        </div>
                                    </div>', $element['element']);
                break;
        }
        return $xhtml;
    }

    public static function showContact ($elements) {
        $xhtml  = null;
        foreach ($elements as $element) {
            $xhtml  .= self::formContract($element);
        };
        return $xhtml;
    }

    public static function formContract ($element, $arrParam = null) {
        $type = isset($element['type']) ? $element['type'] : 'text';
        $xhtml = null;

        switch ($type) {
            case 'text':
                $xhtml  .= sprintf('<div class="col-lg-9 col-md-6" style="margin:auto">
                                        %s
                                    </div>', $element['element']);
                break;
            case 'submit':
                $xhtml  .= sprintf('<div class="col-lg-3 text-center" style="margin:auto">
                                        %s
                                    </div>', $element['element']);
                break;
        }
        return $xhtml;
    }
}