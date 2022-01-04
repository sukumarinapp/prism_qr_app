alter table posout add sesson int(1) default 0;
alter table posmas add STKOUT int(1) default 0;
--update posmas set stkout=1 where ITMCOD=369 and property_id=1;