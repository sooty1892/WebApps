#!/bin/bash
for f in *.php
do
	php -l $f
done