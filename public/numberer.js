// https://en.wikipedia.org/wiki/Eastern_Arabic_numerals
// Arabic: U+0660 through U+0669, 1632
// Farsi:  U+06F0 through U+06F9, 1776
// Urdu:   Same Unicode characters as the Persian, but language is set to Urdu. The numerals 4, 6 and 7 are different from Persian. On some devices, this row may appear identical to Persian.
// https://en.wikipedia.org/wiki/Bengali_numerals
const Tools = {};
Tools.getDigit = function () {
	return Math.floor(Math.random() * 10);
};

Tools.getDigits = function getDigits(n) {
	let digits = [];
	for (let i = 0; i < n; i++) {
		digits.push(Tools.getDigit());
	}

	return digits;
};

Tools.digitsToArabic = function (digits) {
	return digits.map(function(digit) {
		return String.fromCodePoint(1632 + digit);
	});
};

Tools.digitsToBengali = function (digits) {
	return digits.map(function(digit) {
		return String.fromCodePoint(2534 + digit);
	});
};

Tools.digitsToFarsi = function (digits) {
	return digits.map(function(digit) {
		return String.fromCodePoint(1776 + digit);
	});
};

Tools.getDigitsInLanguage = function (lang, digits) {
	if (lang === 'en') {
		return digits;
	} else if (lang === 'ar') {
		return Tools.digitsToArabic(digits);
	} else if (lang === 'bn') {
		return Tools.digitsToBengali(digits);
	}

	// fa, ur
	return Tools.digitsToFarsi(digits);
};

Tools.getRandomInteger = function (min, max) {
	return Math.floor(Math.random() * (max - min)) + min;
};

Object.freeze(Tools);

const UI = {};
UI.possibleLanguages = Object.freeze(['ar', 'fa', 'ur', 'en', 'bn']);
UI.state = {
	source: 'ar',
	target: 'en',
	current: [0], // the current test number
	testIndex: 0
};

UI.fillButtons = function () {
	document.getElementById('numpad').lang = UI.state.target;
	for (let i = 0; i < 10; i++) {
		const n = Tools.getDigitsInLanguage(UI.state.target, [i])[0];
		document.getElementById(`b${i}`).textContent = n;
	}
};

UI.flip = function () {
	document.getElementById('source').value = UI.state.target;
	document.getElementById('target').value = UI.state.source;
	UI.setLanguage();
};

UI.next = function () {
	let numDigits = Tools.getRandomInteger(1, 5);
	const disp = document.getElementById('disp');
	disp.lang = UI.state.source;
	let temp = Tools.getDigits(numDigits);
	while (temp.join('') === UI.state.current.join('') || (temp[0] === 0 && temp.length > 1)) {
		temp = Tools.getDigits(numDigits);
	}
	UI.state.current = temp;
	disp.innerHTML = '';
	const lDigits = Tools.getDigitsInLanguage(UI.state.source, UI.state.current);
	for (let i = 0; i < UI.state.current.length; i++) {
		const step = document.createElement('div');
		step.className = 'step';
		step.textContent = lDigits[i];
		disp.appendChild(step);
	}
	UI.state.testIndex = 0;

	const answer = document.getElementById('answer');
	answer.innerHTML = '';
	answer.lang = UI.state.target;
	for (let i = 0; i < UI.state.current.length; i++) {
		const step = document.createElement('div');
		step.className = 'step';
		step.id = `s${i}`;
		step.innerHTML = '&nbsp;';
		answer.appendChild(step);
	}
};

UI.onKeyUp = function (event) {
	const keyCode = parseInt(event.keyCode);
	if (keyCode > 47 && keyCode < 58) {
		UI.test(keyCode - 48);
	} else if (keyCode > 95 && keyCode < 106) {
		UI.test(keyCode - 96);
	}
};

UI.setLanguage = function () {
	UI.state.source = document.getElementById('source').value;
	UI.state.target = document.getElementById('target').value;
	const queryString = window.location.search;
	const urlParams = new URLSearchParams(queryString);
	urlParams.set('source', UI.state.source);
	urlParams.set('target', UI.state.target);
	var newRelativePathQuery = window.location.pathname + '?' + urlParams.toString();
	history.pushState(null, '', newRelativePathQuery);
	UI.fillButtons();
	UI.next();
};

UI.start = function () {
	const queryString = window.location.search;
	const urlParams = new URLSearchParams(queryString);
	if (UI.possibleLanguages.includes(urlParams.get('source'))) {
		UI.state.source = urlParams.get('source');
	}
	if (UI.possibleLanguages.includes(urlParams.get('target'))) {
		UI.state.target = urlParams.get('target');
	}
	document.getElementById('source').value = UI.state.source;
	document.getElementById('target').value = UI.state.target;
	UI.setLanguage();
	UI.fillButtons();
	UI.next();
};

UI.test = function (n) {
	const step = document.getElementById(`s${UI.state.testIndex}`);
	step.textContent = Tools.getDigitsInLanguage(UI.state.target, [n])[0];
	if (n === UI.state.current[UI.state.testIndex]) {
		step.className = 'step correct';
		UI.state.testIndex++;
		if (UI.state.testIndex === UI.state.current.length) {
			setTimeout(function() {
				UI.next();
			}, 500);
		}
	} else {
		step.className = 'step incorrect';
	}
};
