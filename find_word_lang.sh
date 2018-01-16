for x in `cat php_lang.lst` 
do
	find=`grep "Submission comments" $x` 
	if [ "$find" != "" ] 
	then
		echo $x
		echo "	$find"
	fi
done
