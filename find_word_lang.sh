for x in `cat php_lang.lst` 
do
	find=`grep "Ganti" $x` 
	if [ "$find" != "" ] 
	then
		echo $x
		echo "	$find"
	fi
done
