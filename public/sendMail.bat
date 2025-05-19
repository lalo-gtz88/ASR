set Param1= %1
set Param2= %2
SwithMail.exe /s /from "helpdesk@jmasjuarez.gob.mx" /name "HelpDesk JMAS" /pass "Hd3skT1" /server "172.16.11.7" /p "587" /to "%Param1%" /sub "%Param2%" /btxt "C:\ASR\public\body.txt"

exit

