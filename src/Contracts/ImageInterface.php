<?php

namespace Platina\Image\Contracts;

use Imagick;
use ImagickException;
use Platina\Image\Exception\NotReadableException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Platina\Image\Image;

/**
 * Интерфейс для объекта изображения.
 * @method encode(string $string)
 */
interface ImageInterface
{
    /**
     * Создает объект изображения
     *
     * @param mixed $data Данные для создания изображения (локальный файл, UploadedFile, URL-адрес)
     *
     * @return ImageInterface Объект изображения
     *
     * @throws NotReadableException|FileNotFoundException Исключение, если изображение не может быть прочитано или
     *     обработано.
     */
    public static function make(mixed $data): ImageInterface;

    /**
     * Получает имя файла изображения
     *
     * @return string - Имя файла изображения
     */
    public function getFilename(): string;

    /**
     * Устанавливает ресурс изображения
     *
     * @param Imagick $imageResource - Ресурс изображения
     *
     * @return ImageInterface - Возвращает экземпляр изображения
     */
    public function setImageResource(Imagick $imageResource): ImageInterface;

    /**
     * Устанавливает MIME-тип изображения
     *
     * @param string $mime - MIME-тип изображения
     *
     * @return ImageInterface - Возвращает экземпляр изображения
     */
    public function setMime(string $mime): ImageInterface;

    /**
     * Получает MIME-тип изображения
     *
     * @return string
     */
    public function getMime(): string;

    /**
     * Получает ресурс изображения
     *
     * @return Imagick - Ресурс изображения
     */
    public function getImageResource(): Imagick;

    /**
     * Получает имя директории
     *
     * @return string - Имя директории
     */
    public function getDirname(): string;

    /**
     * Устанавливает имя директории
     *
     * @param string $dirname - Имя директории
     */
    public function setDirname(string $dirname): void;

    /**
     * Устанавливает имя файла
     *
     * @param string $filename - Имя файла
     */
    public function setFilename(string $filename): void;

    /**
     * Получает базовое имя файла
     *
     * @return string - Базовое имя файла
     */
    public function getBasename(): string;

    /**
     * Устанавливает базовое имя файла
     *
     * @param string $basename - Базовое имя файла
     */
    public function setBasename(string $basename): void;

    /**
     * Получить путь, где сохранили изображение
     *
     * @return string
     */
    public function getSavePath(): string;

    /**
     * Изменить путь, где сохранили изображение
     *
     * @param string $savePath
     */
    public function setSavePath(string $savePath): void;

    /**
     * Возвращает содержимое изображения в виде строки.
     *
     * @return string
     * @throws ImagickException
     */
    public function getEncoded(): string;
}
