#!/bin/bash

echo $0 | tee "log.txt"
date --iso-8601=seconds | tee -a "log.txt"
time for filename in ./Data/*.txt; do
    echo $filename
	template=${filename##*/}
	template=${template%.txt}.template
    php ./template.php "$filename" > "./Templates/${template}" 2>>"log.txt"
done
date --iso-8601=seconds | tee -a "log.txt"
