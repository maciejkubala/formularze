
zadanie3_1.sh:
while true
do
clear
date -u '+%H:%M:%S'
sleep
done

zadanie3_2.sh:
x=5
if [ $# -gt 0 ]
then
x=$1
fi
while true
do
clear
date -u +%H:%M:%S'
sleep $x
done

zadanie3_3.sh:
x=`date +%u`
if [ "$x" -lt 6 ]
then
echo "Jest dzien tygodnia, ale nie weekend'owy"
else
echo "Jest weekend"
fi


zadanie3_5.sh
for pierwszy in *
do
for drugi in *
do
x1=`ls -l $pierwszy|cut -c14`
x2=`ls -l $drugi|cut -c14`
if [ "$x1" = 1 ]
then
if [ "$x2" = 1 ]
then
if [ $pierwszy != $drugi ]
then
if cmp -s $pierwszy $drugi
then
echo "Plik $pierwszy jest taki sam jak $drugi"
fi
fi
fi
fi
done
done
