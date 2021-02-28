PROGRAM SayHello(INPUT, OUTPUT);
USES 
  DOS;
VAR
  QueryString: STRING;
  
FUNCTION GetName(VAR QueryString: STRING): STRING;
VAR
  FirstPositionName, I: INTEGER;
  Name: STRING;
BEGIN { GetName }
  Name := '';
  FirstPositionName := POS('name=', QueryString) + 5;
  FOR I := FirstPositionName TO LENGTH(QueryString)
  DO
    BEGIN
      IF QueryString[I] = '&'
      THEN
        BREAK;
      Name := CONCAT(Name, QueryString[I])
    END;
  GetName := Name;             
END; { GetName }

BEGIN {SayHello}
  WRITELN('Content-Type: text/plain');
  WRITELN;
  QueryString := GetEnv('QUERY_STRING'); 
  WRITE('Hello ');
  IF POS('name=', QueryString) <> 0
  THEN
    WRITELN('dear, ' + GetName(QueryString))
  ELSE
    WRITELN('Anonymous!')   
END. {SayHello}
