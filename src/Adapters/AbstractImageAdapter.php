<?php

namespace Platina\Image\Adapters;

use Platina\Image\Contracts\ImageAdapterInterface;
use Platina\Image\Contracts\ImageInterface;

abstract class AbstractImageAdapter implements ImageAdapterInterface
{
    protected function convertToFormat(ImageInterface $image): ImageInterface
    {
        // Получение расширения файла и преобразование его в нижний регистр
        $fileExtension = strtolower($image->getExtension());
        $no_formats = array_map('strtolower', config('image.no_formats'));
        // Проверка, присутствует ли расширение файла в массиве не поддерживаемых форматов
        if (in_array($fileExtension, $no_formats)) {
            // Если формат файла не поддерживается, преобразовываем его в формат JPEG
            $image->encode('jpg');
        }

        return $image;
    }

}
