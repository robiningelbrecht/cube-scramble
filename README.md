# Twisty puzzle scrambler

Tool to generate, verify and analyse scrambles for various twisty puzzles. 
This is not an official WCA scrambler but good enough for casual use.

## Installation

```bash
> composer install robiningelbrecht/twisty-puzzle-scrambler
```

## Usage

### Generate scrambles

```php
$scramble = RandomScramble::twoByTwo();
$scramble = RandomScramble::threeByThree();
$scramble = RandomScramble::fourByFour();
$scramble = RandomScramble::fiveByFive();
$scramble = RandomScramble::sixBySix();
$scramble = RandomScramble::sevenBySeven();
$scramble = CubeScramble::random($scrabmleSize, Size::fromInt($cubeSize))
```

### Create scrambles from notation

### Validate scrambles