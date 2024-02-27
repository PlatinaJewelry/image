<?php

namespace Platina\Image\Adapters;

use Imagick;
use ImagickException;
use Platina\Image\Contracts\ImageAdapterInterface;
use Platina\Image\Contracts\ImageInterface;
use Platina\Image\Exception\NotReadableException;
use Platina\Image\Image;

abstract class AbstractImageAdapter implements ImageAdapterInterface
{
    /**
     * Создает объект изображения на основе полученных данных.
     *
     * @return ImageInterface Объект изображения.
     */
    abstract public function createImageFromData(): ImageInterface;

    /**
     * Преобразует изображение в поддерживаемый формат.
     *
     * @param ImageInterface $image Объект изображения для преобразования.
     *
     * @return ImageInterface Преобразованное изображение.
     */
    protected function convertToFormat(ImageInterface $image): ImageInterface
    {
        // Получение расширения файла и преобразование его в нижний регистр
        $fileExtension = strtolower($image->getExtension());
        // Получение массива форматов из конфигурации и приведение их к нижнему регистру
        $no_formats = array_map('strtolower', config('image.no_formats'));
        // Проверка, присутствует ли расширение файла в массиве не поддерживаемых форматов
        if (in_array($fileExtension, $no_formats)) {
            // Если формат файла не поддерживается, преобразовываем его в формат JPEG
            $image->encode('jpg');
        }

        return $image;
    }

    /**
     * Загрузка изображения из ресурса Imagick.
     *
     * @param Imagick $imagick Ресурс Imagick, представляющий изображение.
     * @param array $fileInfo Информация о файле изображения.
     *
     * @return ImageInterface Возвращает объект изображения после обработки.
     *
     * @throws NotReadableException Исключение выбрасывается в случае ошибки чтения изображения.
     */
    protected function loadImageFromResource(Imagick $imagick, array $fileInfo): ImageInterface
    {
        try {
            $image = new Image();
            // Получить ширину изображения
            $width = $imagick->getImageWidth();
            // Получить высоту изображения
            $height = $imagick->getImageHeight();
            // Устанавливаем ширину изображения
            $image->setImageWidth($width);
            // Устанавливаем высоту изображения
            $image->setImageHeight($height);
            // Установка MIME-типа изображения
            $image->setMime($imagick->getImageMimeType());
            // Установка базового имени файла в объект изображения
            $image->setBasename($fileInfo['basename']);
            // Установка директории, имени файла и базового имени файла в объект ImageFacade
            $image->setDirname($fileInfo['dirname']);
            // Установка имени файла с расширением в объект изображения
            $image->setFilename($fileInfo['filename']);
            // Установка расширения файла
            $image->setExtension($fileInfo['extension']);
            // Установка ресурса изображения Imagick в объект ImageFacade
            $image->setImageResource($imagick);

            return $this->convertToFormat($image);

        } catch (ImagickException $e) {
            // Обрабатываем исключения Imagick, если возникли проблемы при обработке изображения
            throw new NotReadableException("Ошибка обработки изображения: " . $e->getMessage());
        }
    }
}
