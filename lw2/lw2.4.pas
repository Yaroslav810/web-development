PROGRAM WorkWithQueryString(INPUT, OUTPUT);
USES 
  DOS;
   
FUNCTION GetQueryStringParameter(Key: STRING): STRING;
VAR
  FirstPosition, I: INTEGER;
  QueryString, ResultString: STRING;
BEGIN { GetQueryStringParameter }
  QueryString := GetEnv('QUERY_STRING');
  ResultString := '';
  IF POS(CONCAT(Key, '='), QueryString) <> 0
  THEN
    BEGIN
      FirstPosition := POS(CONCAT(Key, '='), QueryString) + LENGTH(Key) + 1;
      FOR I := FirstPosition TO LENGTH(QueryString)
      DO
        BEGIN
          IF QueryString[I] = '&'
          THEN
            BREAK;
          ResultString := CONCAT(ResultString, QueryString[I])
        END
    END;
  GetQueryStringParameter := ResultString        
END; { GetQueryStringParameter }

BEGIN { WorkWithQueryString }
  WRITELN('Content-Type: text/plain');
  WRITELN;
  WRITELN('First Name: ', GetQueryStringParameter('first_name'));
  WRITELN('Last Name: ', GetQueryStringParameter('last_name'));
  WRITELN('Age: ', GetQueryStringParameter('age'))
END. { WorkWithQueryString }
