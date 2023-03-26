// const s1 = '\u00E9'
// https://en.wikipedia.org/wiki/Eastern_Arabic_numerals
// Arabic: U+0660 through U+0669, 1632
// Farsi:  U+06F0 through U+06F9, 1776
// Urdu:   Same Unicode characters as the Persian, but language is set to Urdu. The numerals 4, 6 and 7 are different from Persian. On some devices, this row may appear identical to Persian.

function getDigit() {
	return Math.floor(Math.random() * 10);
}


function getRandomInteger(min, max) {
	return Math.floor(Math.random() * (max - min)) + min;
}

function getDigits(n) {
	let digits = [];
	for (let i = 0; i < n; i++) {
		digits.push(getDigit());
	}

	return digits;
}

function digitsToArabic(digits) {
	return digits.map(function(digit) {
		return String.fromCodePoint(1632 + digit);
	});
}

function digitsToFarsi(digits) {
	return digits.map(function(digit) {
		return String.fromCodePoint(1776 + digit);
	});
}

function digitsToBengali(digits) {
	return digits.map(function(digit) {
		return String.fromCodePoint(2534 + digit);
	});
}
