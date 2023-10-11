<h1 align="center">Twisty puzzle scrambler</h1>

<p align="center">
<a href="https://github.com/robiningelbrecht/twisty-puzzle-scrambler/blob/master/.github/workflows/ci.yml"><img src="https://github.com/robiningelbrecht/twisty-puzzle-scrambler/actions/workflows/ci.yml/badge.svg" alt="CI"></a>
<a href="https://github.com/robiningelbrecht/twisty-puzzle-scrambler/blob/master/LICENSE"><img src="https://img.shields.io/github/license/robiningelbrecht/twisty-puzzle-scrambler?color=428f7e&logo=open%20source%20initiative&logoColor=white" alt="License"></a>
<a href="https://app.codecov.io/gh/robiningelbrecht/twisty-puzzle-scrambler"><img src="https://codecov.io/gh/robiningelbrecht/twisty-puzzle-scrambler/branch/master/graph/badge.svg?token=pj2UH3XLKA"/></a>
<a href="https://phpstan.org/"><img src="https://img.shields.io/badge/PHPStan-level%209-succes.svg?logo=php&logoColor=white&color=31C652" alt="PHPStan Enabled"></a>
<a href="https://php.net/"><img src="https://img.shields.io/packagist/php-v/robiningelbrecht/twisty-puzzle-scrambler/dev-master?color=%23777bb3&logo=php&logoColor=white" alt="PHP"></a>
</p>

---

Tool to generate, verify and analyse scrambles for various twisty puzzles. 
This is not an official WCA scrambler but good enough for casual use.

## Installation

```bash
> composer require robiningelbrecht/twisty-puzzle-scrambler
```

## Usage

### Standard cube

#### Generate random scramble

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

#### Reverse scrambles

```php
$scramble = RandomScramble::threeByThree();
$reversedScramble = $scramble->reverse();
```

#### Output scramble as human-readable notation

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

#### Validate and analyse a scramble

```php
$scramble = CubeScramble::fromNotation(
    "B D R2 U F2 U' R2 U' B2 L2 U2 L2 R2 B' F2 R' U L D' U R'",
    Size::fromInt($cubeSize)
);
```

At that point the scramble is `stringable` or `jsonSerializable`.
When the scramble is invalid, a `InvalidScramble` exception will be thrown.

### Pyraminx

```php
// U' B' L' R' U B U R' l' b u'
$scramble = RandomScramble::pyraminx();
$scramble = PyraminxScramble::random($scrabmleSize)
```

### Skewb

```php
// B L' R L' B' U R' B' U'
$scramble = RandomScramble::skewb();
$scramble = SkewbScramble::random($scrabmleSize)
```

### Megaminx

```php
//  R++ D++ R-- D++ R++ D++ R++ D-- R++ D++ U R++ D-- R-- D-- R-- D++ R++ D-- R++ D++ U...
$scramble = RandomScramble::megaminx();
$scramble = MegaminxScramble::random($scrabmleSize, $numberOfSequences)
```

### Clock

```php
// UR1+ DR3- DL0+ UL6+ U4- R6+ D1- L6+ ALL2+ y2 U1+ R3+ D1- L4+ ALL3- DR DL UL
$scramble = RandomScramble::clock();
$scramble = CockScramble::random()
```

### Sq1

```php
//  (4,0)/ (0,3)/ (3,0)/ (-3,0)/ (2,-1)/ (4,-3)/ (0,-3)/ (0,-2)/ (3,-1)/ (2,-1)/ (3,0)/ (-2,0)/ (3,0)/ (0,-5)
$scramble = RandomScramble::sq1();
$scramble = Sq1Scramble::random($scrabmleSize)
```
