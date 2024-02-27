<?php

namespace Platina\Image\Adapters;

use Imagick;
use ImagickException;
use ImagickPixel;
use Platina\Image\Contracts\ImageInterface;
use Platina\Image\Exception\NotReadableException;
use Platina\Image\Image;

/**
 * Адаптер для создания объекта изображения на основе данных, полученных по URL-адресу
 *
 * Class UrlImageAdapter
 */
class UrlImageAdapter extends AbstractImageAdapter
{
    protected string $url;

    /**
     * Конструктор класса
     *
     * @param string $url URL-адрес, по которому можно получить изображение
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * Метод для создания объекта изображения на основе данных, полученных по URL-адресу
     *
     * @return ImageInterface Объект изображения
     *
     * @throws NotReadableException Выбрасывает исключение, если изображение не может быть прочитано
     */
    public function createImageFromData(): ImageInterface
    {
        try {
            // Создание объекта Imagick для обработки изображения
            $imagick = new Imagick();

            // Загрузка изображения из данных URL
            $binary = @file_get_contents($this->url, false);

            // Проверка на успешную загрузку изображения, иначе выбрасываем исключение
            if ($binary === false) {
                throw new NotReadableException("Ошибка при загрузке изображения с URL-адреса.");
            }

            // Установка фона изображения как прозрачного
            $imagick->setBackgroundColor(new ImagickPixel('transparent'));
            // Установка разрешения (DPI)
            $imagick->setResolution(600, 600);
            // Чтение изображения из данных URL
            $imagick->readImageBlob($binary);

            // Получение имени файла из URL
            $urlInfo = parse_url($this->url);
            // Получение информации о пути URL
            $fileInfo = pathinfo($urlInfo['path']);

            return  $this->loadImageFromResource($imagick, $fileInfo);

        } catch (ImagickException $e) {
            // Обработка исключений Imagick, если возникли проблемы при обработке изображения
            throw new NotReadableException("Ошибка обработки изображения: " . $e->getMessage());
        }
    }
}
