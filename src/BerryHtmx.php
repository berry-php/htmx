<?php

declare(strict_types=1);

namespace Berry\Htmx;

use Berry\Html\HtmlTag;
use Berry\Html\HtmlVoidTag;
use Closure;
use Deprecated;
use Stringable;

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
            'hxQuery' => static::hxQuery(),
            'hxAction' => static::hxAction(),
            'hxMethod' => static::hxMethod(),
            'hxConfig' => static::hxConfig(),
            'hxStatus' => static::hxStatus(),
            'hxIgnore' => static::hxIgnore(),
            'hxMorphSkip' => static::hxMorphSkip(),
            'hxMorphSkipChildren' => static::hxMorphSkipChildren(),
            'hxPreload' => static::hxPreload(),
            'hxPending' => static::hxPending(),
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
        return static fn(HtmlTag|HtmlVoidTag $node, string $url): HtmlTag|HtmlVoidTag => $node->attr($attr, $url);
    }

    private static function hxQuery(): Closure
    {
        return self::requestMethod('hx-query');
    }

    private static function hxAction(): Closure
    {
        return self::simpleString('hx-action');
    }

    private static function hxMethod(): Closure
    {
        return self::simpleString('hx-method');
    }

    private static function hxConfig(): Closure
    {
        return self::simpleString('hx-config');
    }

    private static function hxStatus(): Closure
    {
        return static fn(
            HtmlTag|HtmlVoidTag $node,
            int|string $code,
            string $config,
            bool $inherited = false,
            bool $append = false,
        ): HtmlTag|HtmlVoidTag => $node->attr(self::attributeName("hx-status:{$code}", $inherited, $append), $config);
    }

    private static function hxIgnore(): Closure
    {
        return self::simpleFlag('hx-ignore');
    }

    private static function hxMorphSkip(): Closure
    {
        return self::simpleFlag('hx-morph-skip');
    }

    private static function hxMorphSkipChildren(): Closure
    {
        return self::simpleFlag('hx-morph-skip-children');
    }

    private static function hxPreload(): Closure
    {
        return self::simpleString('hx-preload');
    }

    private static function hxPending(): Closure
    {
        return self::simpleString('hx-pending');
    }

    private static function hxOn(): Closure
    {
        return static fn(HtmlTag|HtmlVoidTag $node, string $event, ?string $js = null): HtmlTag|HtmlVoidTag => $js
            === null
                ? $node->attr('hx-on', $event)
                : $node->attr("hx-on:{$event}", $js);
    }

    private static function simpleBool(string $attr): Closure
    {
        return static fn(
            HtmlTag|HtmlVoidTag $node,
            bool $value,
            bool $inherited = false,
            bool $append = false,
        ): HtmlTag|HtmlVoidTag => $node->attr(
            self::attributeName($attr, $inherited, $append),
            $value ? 'true' : 'false',
        );
    }

    /**
     * @return Closure(HtmlTag|HtmlVoidTag, bool|float|int|string|Stringable|null, bool=, bool=): (HtmlTag|HtmlVoidTag)
     */
    private static function simpleString(string $attr): Closure
    {
        return static function (
            HtmlTag|HtmlVoidTag $node,
            bool|float|int|string|Stringable|null $string,
            bool $inherited = false,
            bool $append = false,
        ) use ($attr): HtmlTag|HtmlVoidTag {
            if (is_bool($string)) {
                $string = $string ? 'true' : 'false';
            }
            return $node->attr(self::attributeName($attr, $inherited, $append), strval($string));
        };
    }

    private static function deprecatedString(string $attr): Closure
    {
        $method = self::simpleString($attr);

        return #[Deprecated(
            "This attribute is obsolete; see the helper documentation for alternatives.\nWill be removed with 0.6.",
        )]
        static fn(
            HtmlTag|HtmlVoidTag $node,
            bool|float|int|string|Stringable|null $string,
            bool $inherited = false,
            bool $append = false,
        ): HtmlTag|HtmlVoidTag => $method($node, $string, $inherited, $append);
    }

    private static function attributeName(string $attr, bool $inherited, bool $append): string
    {
        return $attr . ($inherited ? ':inherited' : '') . ($append ? ':append' : '');
    }

    private static function hxBoost(): Closure
    {
        return static fn(
            HtmlTag|HtmlVoidTag $node,
            bool|string $value,
            bool $inherited = false,
            bool $append = false,
        ): HtmlTag|HtmlVoidTag => $node->attr(
            self::attributeName('hx-boost', $inherited, $append),
            is_bool($value) ? ($value ? 'true' : 'false') : $value,
        );
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
        return self::deprecatedString('hx-ext');
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
        return self::deprecatedString('hx-params');
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
        return self::deprecatedString('hx-request');
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
        return self::deprecatedString('hx-disinherit');
    }

    private static function hxInherit(): Closure
    {
        return self::deprecatedString('hx-inherit');
    }

    private static function hxHistoryElt(): Closure
    {
        return self::simpleFlag('hx-history-elt');
    }

    private static function hxDisabledElt(): Closure
    {
        return self::deprecatedString('hx-disabled-elt');
    }

    private static function simpleFlag(string $attr): Closure
    {
        return static fn(HtmlTag|HtmlVoidTag $node): HtmlTag|HtmlVoidTag => $node->flag($attr);
    }

    private static function hxDisable(): Closure
    {
        return static fn(
            HtmlTag|HtmlVoidTag $node,
            string $selector,
            bool $inherited = false,
            bool $append = false,
        ): HtmlTag|HtmlVoidTag => $node->attr(self::attributeName('hx-disable', $inherited, $append), $selector);
    }

    private static function hxHistory(): Closure
    {
        return #[Deprecated("History restoration refetches pages; remove this attribute.\nWill be removed with 0.6.")]
        static fn(
            HtmlTag|HtmlVoidTag $node,
            bool $value,
            bool $inherited = false,
            bool $append = false,
        ): HtmlTag|HtmlVoidTag => $node->attr(
            self::attributeName('hx-history', $inherited, $append),
            $value ? 'true' : 'false',
        );
    }

    private static function hxTarget(): Closure
    {
        return static function (
            HtmlTag|HtmlVoidTag $node,
            HxTarget|string $val,
            bool $inherited = false,
            bool $append = false,
        ): HtmlTag|HtmlVoidTag {
            if ($val instanceof HxTarget) {
                $val = $val->value;
            }

            return $node->attr(self::attributeName('hx-target', $inherited, $append), $val);
        };
    }

    private static function hxSwap(): Closure
    {
        return static function (
            HtmlTag|HtmlVoidTag $node,
            HxSwap|string $val,
            bool $inherited = false,
            bool $append = false,
        ): HtmlTag|HtmlVoidTag {
            if ($val instanceof HxSwap) {
                $val = $val->value;
            }

            return $node->attr(self::attributeName('hx-swap', $inherited, $append), $val);
        };
    }
}
