#!/bin/bash
for f in $(find . -name '*.php')
do
	php -l $f
done