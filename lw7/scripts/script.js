function isPrimeNumber(n)
{
  if (typeof n === 'number' && !isNaN(n))
  {
    checkPrime(n);
  }
  else
  {
    console.log(n + " не число");
  }
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
  if (isPrime) {
    console.log('Result: ' + n + ' is prime number')
  } else {
    console.log('Result: ' + n + ' is not prime number')
  }
}