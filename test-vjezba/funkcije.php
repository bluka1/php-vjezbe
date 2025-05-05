<?php

function brojSlova($string) {
  return mb_strlen($string);
}

function sadrziA($nekiString) {
  return mb_strpos(mb_strtolower($nekiString), 'a') !== false ? 'DA' : 'NE';
}

function velikaSlova($string) {
  return mb_strtoupper($string);
}

function malaSlova($string) {
  return mb_strtolower($string);
}