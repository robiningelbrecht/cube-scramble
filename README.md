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
// R F2 U' R' U2 F R' F2 R' U'
$scramble = RandomScramble::twoByTwo();
// R2 F' R2 D2 B R2 F' L2 U2 F' R2 F' U' F2 R D2 F L R U' L'
$scramble = RandomScramble::threeByThree();
// F2 L2 F' U2 L2 B2 D' R2 D' R2 U2 L2 R2 U2 R D' F2 L' D2 B' R Uw2 R' B2 Uw2...
$scramble = RandomScramble::fourByFour();
// R' Fw Uw Lw2 Dw U L2 B2 R2 Lw' L F2 Dw' B2 R Rw' L2 Bw' Uw2 D' U' L' Bw D...
$scramble = RandomScramble::fiveByFive();
// L D' B L2 3Fw' Fw' Uw2 U' R2 3Rw 3Uw Bw' 3Rw2 Rw' Uw2 3Uw2 3Rw' L2 Lw' D F2...
$scramble = RandomScramble::sixBySix();
// 3Bw2 3Rw' 3Dw Uw' 3Bw2 3Rw2 Lw' F B' D Lw' 3Bw' D2 Uw2 3Fw U2 3Lw' 3Dw' B Fw'...
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

```
Turn the right layer 180°
Turn the bottom layer 90° clockwise
Turn the back layer 90° counterclockwise
Turn the bottom layer 180°
Turn the left layer 90° counterclockwise
Turn the back layer 90° counterclockwise
Turn the right layer 90° counterclockwise
Turn the back layer 180°
Turn the top layer 90° clockwise
Turn the right layer 180°
...
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

Same goes for Pyraminx scrambles

```php
$scramble = RandomScramble::pyraminx();
$scramble = PyraminxScramble::random($scrabmleSize)
```