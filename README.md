# Twisty puzzle scrambler

Tool to generate, verify and analyse scrambles for various twisty puzzles. 
This is not an official WCA scrambler but good enough for casual use.

## Installation

```bash
> composer install robiningelbrecht/twisty-puzzle-scrambler
```

## Usage

### Standard cube

The `RandomScramble` factory generates scrambles that are WCA compliant (in size).

```php
$scramble = RandomScramble::twoByTwo();
$scramble = RandomScramble::threeByThree();
$scramble = RandomScramble::fourByFour();
$scramble = RandomScramble::fiveByFive();
$scramble = RandomScramble::sixBySix();
$scramble = RandomScramble::sevenBySeven();
```

Or you can generate scrambles yourself

```php
$scramble = CubeScramble::random($scrabmleSize, Size::fromInt($cubeSize))
```

It's also possible to reverse scrambles

```php
$scramble = RandomScramble::threeByThree();
$reversedScramble = $scramble->reverse();
```

Or output a human-readable notation for a scramble

```php
$scramble = RandomScramble::threeByThree();
print_r($scramble->forHumans());
```

If you want to initialize a `Scramble` object from a given scramble, use

```php
$scramble = RandomScramble::fromNotation(
    "B D R2 U F2 U' R2 U' B2 L2 U2 L2 R2 B' F2 R' U L D' U R'",
    Size::fromInt($cubeSize)
);
```

From there on the scramble is `stringable` or `jsonSerializable`.

### Pyraminx

Same goes for Pyraminx scrambles:

```php
$scramble = RandomScramble::pyraminx();
$scramble = PyraminxScramble::random($scrabmleSize)
```

### Validate scrambles