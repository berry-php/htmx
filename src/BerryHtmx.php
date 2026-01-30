<?php declare(strict_types=1);

namespace Berry\Htmx;

use Berry\Html\HtmlTag;
use Berry\Html\HtmlVoidTag;
use Closure;

final readonly class BerryHtmx
{
    public static function install(): void
    {
        $methods = [
            'hxGet' => static::hxGet(),
            'hxPost' => static::hxPost(),
            'hxPut' => static::hxPut(),
            'hxPatch' => static::hxPatch(),
            'hxDelete' => static::hxDelete(),
            'hxOn' => static::hxOn(),
            'hxBoost' => static::hxBoost(),
            'hxConfirm' => static::hxConfirm(),
            'hxDisable' => static::hxDisable(),
            'hxEncoding' => static::hxEncoding(),
            'hxExt' => static::hxExt(),
            'hxHistory' => static::hxHistory(),
            'hxInclude' => static::hxInclude(),
            'hxIndicator' => static::hxIndicator(),
            'hxParams' => static::hxParams(),
            'hxPreserve' => static::hxPreserve(),
            'hxPrompt' => static::hxPrompt(),
            'hxPushUrl' => static::hxPushUrl(),
            'hxReplaceUrl' => static::hxReplaceUrl(),
            'hxRequest' => static::hxRequest(),
            'hxSelect' => static::hxSelect(),
            'hxSelectOob' => static::hxSelectOob(),
            'hxSwapOob' => static::hxSwapOob(),
            'hxSync' => static::hxSync(),
            'hxTarget' => static::hxTarget(),
            'hxTrigger' => static::hxTrigger(),
            'hxValidate' => static::hxValidate(),
            'hxVals' => static::hxVals(),
            'hxHeaders' => static::hxHeaders(),
            'hxSwap' => static::hxSwap(),
            'hxDisinherit' => static::hxDisinherit(),
            'hxInherit' => static::hxInherit(),
            'hxHistoryElt' => static::hxHistoryElt(),
            'hxDisabledElt' => static::hxDisabledElt(),
        ];

        foreach ($methods as $name => $func) {
            HtmlTag::addMethod($name, $func);
            HtmlVoidTag::addMethod($name, $func);
        }
    }

    private static function hxGet(): Closure
    {
        return self::requestMethod('hx-get');
    }

    private static function hxPost(): Closure
    {
        return self::requestMethod('hx-post');
    }

    private static function hxPut(): Closure
    {
        return self::requestMethod('hx-put');
    }

    private static function hxPatch(): Closure
    {
        return self::requestMethod('hx-patch');
    }

    private static function hxDelete(): Closure
    {
        return self::requestMethod('hx-delete');
    }

    private static function requestMethod(string $attr): Closure
    {
        return function (HtmlTag|HtmlVoidTag $node, string $url) use ($attr): HtmlTag|HtmlVoidTag {
            return $node->attr($attr, $url);
        };
    }

    private static function hxOn(): Closure
    {
        return function (HtmlTag|HtmlVoidTag $node, string $event, string $js): HtmlTag|HtmlVoidTag {
            return $node->attr("hx-on:$event", $js);
        };
    }

    private static function simpleBool(string $attr): Closure
    {
        return function (HtmlTag|HtmlVoidTag $node, bool $value) use ($attr): HtmlTag|HtmlVoidTag {
            return $node->attr($attr, $value ? 'true' : 'false');
        };
    }

    private static function simpleString(string $attr): Closure
    {
        return function (HtmlTag|HtmlVoidTag $node, string $string) use ($attr): HtmlTag|HtmlVoidTag {
            return $node->attr($attr, $string);
        };
    }

    private static function hxBoost(): Closure
    {
        return self::simpleBool('hx-boost');
    }

    private static function hxConfirm(): Closure
    {
        return self::simpleString('hx-confirm');
    }

    private static function hxEncoding(): Closure
    {
        return self::simpleString('hx-encoding');
    }

    private static function hxExt(): Closure
    {
        return self::simpleString('hx-ext');
    }

    private static function hxInclude(): Closure
    {
        return self::simpleString('hx-include');
    }

    private static function hxIndicator(): Closure
    {
        return self::simpleString('hx-indicator');
    }

    private static function hxParams(): Closure
    {
        return self::simpleString('hx-params');
    }

    private static function hxPreserve(): Closure
    {
        return self::simpleFlag('hx-preserve');
    }

    private static function hxPrompt(): Closure
    {
        return self::simpleString('hx-prompt');
    }

    private static function hxPushUrl(): Closure
    {
        return self::simpleString('hx-push-url');
    }

    private static function hxReplaceUrl(): Closure
    {
        return self::simpleString('hx-replace-url');
    }

    private static function hxRequest(): Closure
    {
        return self::simpleString('hx-request');
    }

    private static function hxSelect(): Closure
    {
        return self::simpleString('hx-select');
    }

    private static function hxSelectOob(): Closure
    {
        return self::simpleString('hx-select-oob');
    }

    private static function hxSwapOob(): Closure
    {
        return self::simpleString('hx-swap-oob');
    }

    private static function hxSync(): Closure
    {
        return self::simpleString('hx-sync');
    }

    private static function hxTrigger(): Closure
    {
        return self::simpleString('hx-trigger');
    }

    private static function hxValidate(): Closure
    {
        return self::simpleBool('hx-validate');
    }

    private static function hxVals(): Closure
    {
        return self::simpleString('hx-vals');
    }

    private static function hxHeaders(): Closure
    {
        return self::simpleString('hx-headers');
    }

    private static function hxDisinherit(): Closure
    {
        return self::simpleString('hx-disinherit');
    }

    private static function hxInherit(): Closure
    {
        return self::simpleString('hx-inherit');
    }

    private static function hxHistoryElt(): Closure
    {
        return self::simpleFlag('hx-history-elt');
    }

    private static function hxDisabledElt(): Closure
    {
        return self::simpleString('hx-disabled-elt');
    }

    private static function simpleFlag(string $attr): Closure
    {
        return function (HtmlTag|HtmlVoidTag $node) use ($attr): HtmlTag|HtmlVoidTag {
            return $node->flag($attr);
        };
    }

    private static function hxDisable(): Closure
    {
        return self::simpleFlag('hx-disable');
    }

    private static function hxHistory(): Closure
    {
        return self::simpleBool('hx-history');
    }

    private static function hxTarget(): Closure
    {
        return function (HtmlTag|HtmlVoidTag $node, HxTarget|string $val): HtmlTag|HtmlVoidTag {
            if ($val instanceof HxTarget) {
                $val = $val->value;
            }

            return $node->attr('hx-target', $val);
        };
    }

    private static function hxSwap(): Closure
    {
        return function (HtmlTag|HtmlVoidTag $node, HxSwap|string $val): HtmlTag|HtmlVoidTag {
            if ($val instanceof HxSwap) {
                $val = $val->value;
            }

            return $node->attr('hx-swap', $val);
        };
    }
}
