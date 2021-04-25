function isPrimeNumber(n)
{
  if (isInteger(n))
  {
    checkPrime(n);
    return;
  }

  if (Array.isArray(n))
  {
    let checkOnNumber = n.every(isNumber) && n.length > 0;
    if (checkOnNumber)
    {
      n.forEach((item) => checkPrime(item))
    }
    else
    {
      console.log('The array must not be empty and consist only of numbers');
    }
    return;
  }

  console.log('Invalid data');
}

function checkPrime(n)
{
  let isPrime;
  for (let i = 2; i <= n; i++) {
    isPrime = true;
    for (let j = 2; j < i; j++) {
      if (i % j === 0) {
        isPrime = false;
        break;
      }
    }
  }
  if ((isPrime) && (n > 1)) {
    console.log('Result: ' + n + ' is prime number')
  } else {
    console.log('Result: ' + n + ' is not prime number')
  }
}

function isNumber(n) {
  return (typeof n === 'number' && !isNaN(n));
}

function isInteger(n) {
  return Number.isInteger(n);
}