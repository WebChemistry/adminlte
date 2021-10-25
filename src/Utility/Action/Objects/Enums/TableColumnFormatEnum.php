<?php declare(strict_types = 1);

namespace WebChemistry\AdminLTE\Utility\Action\Objects\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static self DATETIME()
 * @method static self DATE()
 * @method static self HTML_TO_TEXT()
 * @method static self LINK()
 * @method static self LINK_BTN()
 */
final class TableColumnFormatEnum extends Enum
{

	private const DATETIME = 'datetime';
	private const DATE = 'date';
	private const HTML_TO_TEXT = 'html_to_text';
	private const LINK = 'link';
	private const LINK_BTN = 'link_btn';

}
