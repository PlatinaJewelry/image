<?php

namespace Platina\Image\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Фасад для удобного доступа к функциональности работы с изображениями
 *
 * @method static PLImage make(mixed $data): ImageInterface Создает объект изображения
 * @method PLImage save(string $path = "", int $quality = null): Image Сохраняет изображение в указанный путь с заданным
 *     качеством.
 * @method PLImage flip(string $mode = 'h'): Image Обрабатывает отражение изображения по горизонтали или
 *     вертикали. Режим отражения: 'h' для горизонтального, 'v' для вертикального.
 * @method PLImage crop(int $width, int $height, ?int $x = null, ?int $y = null): Image Обрезает изображение до
 *     указанных размеров с возможностью установки координат верхнего левого угла.
 * @method PLImage encode(string $format): Image Кодирует изображение в определенный формат.
 * @method PLImage resize(?int $width, ?int $height): Image Изменяет размер изображения на заданную ширину и
 *     высоту сохраняя пропорции.
 * @method PLImage orientate(): Image Изменяет ориентацию изображения. Автоматически повернет изображение так,
 *     чтобы оно было правильно отображено.
 * @method PLImage response(array $headers = []): Response Создает HTTP-ответ на основе изображения. Полезно, когда нужно
 *     вернуть изображение как ответ на запрос.
 * @method PLImage stream(array $headers = []): StreamedResponse Выводит изображение в виде потока. Полезен, когда нужно
 *     передать большие файлы клиенту по мере их генерации или обработки, минимизируя использование памяти.
 * @method PLImage rotate(int $angle): Image Поворачивает изображение на заданный угол.
 * @method PLImage optimize(): Image Выполняет оптимизацию, уменьшая размер файла изображения, сохраняя при этом
 *     его визуальное качество.
 * @method PLImage mirror(string $mode = 'h'): Image Зеркально отражает изображение по горизонтали или
 *     вертикали. Режим отражения: 'h' для горизонтального, 'v' для вертикального.
 * @method PLImage blur(float $radius = 5, float $sigma = 1): Image Применяет размытие к изображению.
 * @method PLImage brightness(float $brightness): Image Регулирует яркость изображения.
 *     Уровень яркости (0 - оригинал,
 *     > 0 - увеличить, < 0 - уменьшить).
 * @method PLImage contrast(float $contrast): Image Регулирует контраст изображения.
 *     Уровень контраста (0 - оригинал,
 *     > 0 - увеличить, < 0 - уменьшить).
 * @method PLImage grayscale(): Image Преобразует изображение в черно-белый (оттенки серого).
 * @method PLImage sharpen(float $amount = 2, float $radius = 1, float $sigma = 0.5):
 *     Image Применяет эффект заточки к изображению.
 * @method PLImage textOverlay(string $text, int $x, int $y, string $font, int $fontSize, string $color = '#000000'):
 *     Image Добавляет текстовое наложение на изображение.
 * @method PLImage watermark(string $watermarkPath, int $x, int $y, int $opacity = 50):
 *     Image Добавляет водяной знак на изображение.
 * @method backup(): Создает резервную копию изображения.
 * @method reset(): Восстанавливает изображение из резервной копии.
 * @method getSavePath(): Получить путь, где сохранили изображение
 * @method getImageWidth(): Геттер для получения значения ширины изображения
 * @method getImageHeight(): Геттер для получения значения высоты изображения
 */
class PLImage extends Facade
{
    /**
     * Получает имя зарегистрированного компонента
     *
     * @return string   Имя компонента
     */
    protected static function getFacadeAccessor(): string
    {
        return 'PLImage';
    }
}
