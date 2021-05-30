function isPrimeNumber(n)
{
  if (isInteger(n)) {
    checkPrime(n);
    return;
  }

  if (Array.isArray(n)) {
    let checkOnNumber = n.every(isInteger) && n.length > 0;
    if (checkOnNumber) {
      n.forEach((item) => checkPrime(item))
    } else {
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

function isInteger(n) {
  return Number.isInteger(n);
}

// ------------------------------------------------ //
const ARITHMETIC_SIGNS = ['+', '-', '*', '/'];
const BRACKETS = ['(', ')'];

function calc(string) {
  let stack = [];
  let number = "";

  if (!checkParentheses(string)) {
    console.log("Error in brackets!");
    return;
  }

  string = string.trim().replace('(', ' ').replace(')', ' ');

  for (let i = 0; i < string.length; i++) {
    if ((!ARITHMETIC_SIGNS.indexOf(string[i]) === -1) && !isDigit(string[i])) continue;

    if (ARITHMETIC_SIGNS.indexOf(string[i]) !== -1) {
      stack.push(string[i]);
    }

    if (isDigit(string[i])) {
      number += string[i];
      if (!isDigit(string[i + 1])) {
        while (lastInStackIsNumber(stack)) {
          let operand = stack.pop();
          let operator = stack.pop();
          number = calculate(operator, parseInt(operand), parseInt(number));
        }
        stack.push(number);
        number = "";
      }
    }
  }

  console.log(stack.pop());
}

function calculate(operator, operand1, operand2) {
  switch (operator) {
    case '+':
      return operand1 + operand2;
    case '-':
      return operand1 - operand2;
    case '*':
      return operand1 * operand2;
    case '/':
      return operand1 / operand2;
  }
}

function checkParentheses(string) {
  let bracketsNumber = 0;
  for (let i = 0; i < string.length; i++) {
    if (BRACKETS.indexOf(string[i]) !== -1) {
      if (string[i] === '(') {
        bracketsNumber++;
      }
      if (string[i] === ')') {
        if (bracketsNumber === 0) return false;
        bracketsNumber--;
      }
    }
  }

  return bracketsNumber === 0;
}

function isDigit(n) {
  return !isNaN(parseInt(n));
}

function lastInStackIsNumber(stack) {
  let a = stack.pop();
  stack.push(a);

  return isDigit(a);
}
