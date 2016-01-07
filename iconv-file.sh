#/bin/sh
cd test
find ./ type f -name "*.php" | while read line;do
echo $line
iconv -f gb2312 -t UTF-8 $line > ${line}.utf8
mv ${line}.utf8 $line
done
