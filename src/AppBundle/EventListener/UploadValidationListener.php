<?php

namespace AppBundle\EventListener;

use Oneup\UploaderBundle\Event\ValidationEvent;
use Oneup\UploaderBundle\Uploader\Exception\ValidationException;

class UploadValidationListener
{
    public function onValidate(ValidationEvent $event)
    {
        $config  = $event->getConfig();
        $file    = $event->getFile();
        $type    = $event->getType();
        $request = $event->getRequest();

        // do some validations
        //throw new ValidationException('Validation File : [' . $file . '] / original date : ['. date('Y-m-d H:n',$request->get('fileLastModified')) .']');
    }
}