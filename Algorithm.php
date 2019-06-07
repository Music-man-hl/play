<?php

class Algorithm
{
    /*
     * 最长不重复子串数
     */

    public function lengthOfNonRepeatingSubStr($str): int
    {
        $lastPosition = [];
        $start = 0;
        $maxLength = 0;
        for ($i = 0; $i < strlen($str); $i++) {
            if (isset($lastPosition[$str{$i}])) {
                if ($lastPosition[$str{$i}] > $start) {
                    $start = $lastPosition[$str{$i}] + 1;
                }
            }
            if ($i - $start + 1 > $maxLength) {
                $maxLength = $i - $start + 1;
            }
            $lastPosition[$str{$i}] = $i;
        }
        return $maxLength;
    }


    /*
     * 最大子数组的和
     */

    public function totalOfMaxSubArrayWithSimple(array $array)
    {

        $sum = 0;
        for ($i = 0; $i < count($array); $i++) {
            $tmpSum = $array[$i];
            for ($j = $i + 1; $j < count($array); $j++) {
                $tmpSum += $array[$j];
                if ($tmpSum > $sum) {
                    $sum = $tmpSum;
                }
            }
        }
        return $sum;
    }

    public function totalOfMaxSubArray(array $array)
    {
        $left = 0;
        $right = count($array) - 1;
        $mid = floor(($left + $right) / 2);
        if ($left == $right) {
            return $array[$left];
        }
        $leftMax = $this->totalOfMaxSubArray(array_slice($array, $left, $mid - $left + 1));
        $rightMax = $this->totalOfMaxSubArray(array_slice($array, $mid + 1, $right - $mid));
        $midMax = $this->totalOfMaxCrossing($array);
        if ($leftMax > $rightMax && $leftMax > $midMax) {
            return $leftMax;
        } else if ($rightMax > $midMax && $rightMax > $leftMax) {
            return $rightMax;
        } else {
            return $midMax;
        }
    }

    public function totalOfMaxCrossing(array $array)
    {
        $leftTotalMax = PHP_INT_MIN;
        $rightTotalMax = PHP_INT_MIN;

        $left = 0;
        $right = count($array) - 1;
        $mid = (int)floor(($left + $right) / 2);

        $i = $mid;
        $temp = 0;
        while ($i >= $left) {
            $temp += $array[$i];
            if ($temp > $leftTotalMax) {
                $leftTotalMax = $temp;
            }
            $i--;
        }

        $i = $mid + 1;
        $temp = 0;
        while ($i <= $right) {
            $temp += $array[$i];
            if ($temp > $rightTotalMax) {
                $rightTotalMax = $temp;
            }
            $i++;
        }
        return $leftTotalMax + $rightTotalMax;
    }

}


$algorithm = new Algorithm();
// echo $algorithm->lengthOfNonRepeatingSubStr('aabcdeefgefgabcdefgihrtnmeuig')."\n";

($array = range(-11500, 11500)) && shuffle($array);

$t1 = microtime();
echo $algorithm->totalOfMaxSubArrayWithSimple($array) . "\n";
$t2 = microtime();
echo $algorithm->totalOfMaxSubArray($array) . "\n";
$t3 = microtime();
$a1 = explode(' ', $t1);
$a2 = explode(' ', $t2);
$a3 = explode(' ', $t3);
echo(($a2[1] - $a1[1]) + ($a2[0] - $a1[0]));
echo '   ';
echo(($a3[1] - $a2[1]) + ($a3[0] - $a2[0]));