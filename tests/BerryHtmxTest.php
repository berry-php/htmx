<?php declare(strict_types=1);

use Berry\Htmx\BerryHtmx;
use Berry\Htmx\HxSwap;
use Berry\Htmx\HxTarget;

use function Berry\Html\button;
use function Berry\Html\div;
use function Berry\Html\input;

beforeAll(function () {
    BerryHtmx::install();
});

test('hx-boost handles booleans', function () {
    expect(div()->hxBoost(value: true)->toString())->toBe('<div hx-boost="true"></div>');
    expect(div()->hxBoost(value: false)->toString())->toBe('<div hx-boost="false"></div>');
});

test('Regression: hxSwapOob should allow bool', function () {
    expect(div()->hxSwapOob(true)->toString())->toBe('<div hx-swap-oob="true"></div>');
});

test('inheritance is opt-in and append follows inherited', function () {
    expect(div()->hxTarget('#output', inherited: true)->toString())
        ->toBe('<div hx-target:inherited="#output"></div>');
    expect(div()->hxTarget('#output')->toString())->toBe('<div hx-target="#output"></div>');
    expect(div()->hxVals('source:save', append: true)->toString())
        ->toBe('<div hx-vals:append="source:save"></div>');
    expect(div()->hxVals('tenant:acme', inherited: true, append: true)->toString())
        ->toBe('<div hx-vals:inherited:append="tenant:acme"></div>');
    expect(input()->hxValidate(false, inherited: true)->toString())
        ->toBe('<input hx-validate:inherited="false" />');
    expect(div()->hxBoost('transition:true', inherited: true)->toString())
        ->toBe('<div hx-boost:inherited="transition:true"></div>');
});

test('status patterns and exact codes retain separate overrides with inheritance', function () {
    expect(input()->hxQuery('/search')->hxStatus('4xx', 'swap:none', inherited: true)->hxStatus(422, 'target:#errors')->toString())
        ->toBe('<input hx-query="/search" hx-status:4xx:inherited="swap:none" hx-status:422="target:#errors" />');
});

test('URL booleans serialize as explicit strings rather than HTML flags', function () {
    expect(button()->hxPushUrl(true)->hxReplaceUrl(false)->toString())
        ->toBe('<button hx-push-url="true" hx-replace-url="false"></button>');
});

test('event handlers support colon event names and extended trigger expressions', function () {
    expect(div()->hxOn(':before:request', 'console.log(event)')->hxOn('htmx:after:swap', 'done()')->toString())
        ->toBe('<div hx-on::before:request="console.log(event)" hx-on:htmx:after:swap="done()"></div>');
    expect(input()->hxOn("keydown[key=='Escape'] -> this.blur(); click once -> run()")->toString())
        ->toBe('<input hx-on="keydown[key==&#039;Escape&#039;] -&gt; this.blur(); click once -&gt; run()" />');
});

test('enum arguments serialize their backed values without losing modifiers', function () {
    expect(div()->hxSwap(HxSwap::OuterMorph, inherited: true)->toString())
        ->toBe('<div hx-swap:inherited="outerMorph"></div>');
    expect(div()->hxTarget(HxTarget::Previous)->toString())->toBe('<div hx-target="previous"></div>');
});
