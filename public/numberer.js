// https://en.wikipedia.org/wiki/Eastern_Arabic_numerals
// Arabic: U+0660 through U+0669, 1632
// Farsi:  U+06F0 through U+06F9, 1776
// Urdu:   Same Unicode characters as the Persian, but language is set to Urdu. The numerals 4, 6 and 7 are different from Persian. On some devices, this row may appear identical to Persian.
// https://en.wikipedia.org/wiki/Bengali_numerals
const Tools = {};

Tools.addClass = function(element, className) {
	let classes = element.className.split(' ');
	if (!classes.includes(className)) {
		classes.push(className);
		element.className = classes.join(' ');
	}
};

Tools.removeClass = function(element, className) {
	let classes = element.className.split(' ');
	let index = classes.indexOf(className);

	if (index !== -1) {
		classes.splice(index, 1);
	}

	element.className = classes.join(' ');
}

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
UI.possibleModes = Object.freeze(['match', 'math']);
UI.state = {
	current: [0], // the current test number
	guess: [],
	guessWidth: 0,
	mode: 'match',
	source: 'ar',
	target: 'en',
	testIndex: 0
};

UI.addStep = function(parent, text, id, className) {
	const step = document.createElement('div');
	Tools.addClass(step, 'step');
	if (!!id) { step.id = id; }
	if (!!className) { Tools.addClass(step, className); }
	step.innerHTML = text;
	parent.appendChild(step);
};

UI.backspace = function() {
	UI.state.guess.pop();
	UI.displayGuess();
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

UI.next = function() {
	if (UI.state.mode === 'match') {
		UI.nextMatch();
	} else {
		UI.nextMath();
	}
}

UI.nextMatch = function () {
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
		UI.addStep(disp, lDigits[i]);
	}
	UI.state.testIndex = 0;

	const answer = document.getElementById('answer');
	answer.innerHTML = '';
	answer.lang = UI.state.target;
	for (let i = 0; i < UI.state.current.length; i++) {
		UI.addStep(answer, '&nbsp;', `s${i}`);
	}
};

UI.nextMath = function() {
	UI.state.guess = [];
	let a = Tools.getRandomInteger(1, 99);
	let b = Tools.getRandomInteger(1, 99);
	while (a === b) {
		b = Tools.getRandomInteger(1, 99);
	}
	if (a < b) {
		let t = a;
		a = b;
		b = t;
	}
	UI.state.guessWidth = Math.max(('' + a).length, ('' + b).length) + 2;
	const operator = Math.random() < 0.5 ? '+' : '-';
	UI.state.current = ('' + (operator === '+' ? a + b : a - b)).split('');
	const disp = document.getElementById('disp');
	disp.lang = UI.state.source;
	disp.innerHTML = '';
	const aDigits = Tools.getDigitsInLanguage(UI.state.source, (''+a).split('').map(n => parseInt(n)));
	const bDigits = Tools.getDigitsInLanguage(UI.state.source, (''+b).split('').map(n => parseInt(n)));
	aDigits.forEach(function(n) {
		UI.addStep(disp, n);
	});
	const hr = document.createElement('br');
	disp.appendChild(hr);
	UI.addStep(disp, operator);
	UI.addStep(disp, '&nbsp;');
	bDigits.forEach(function(n) {
		UI.addStep(disp, n);
	});

	UI.state.testIndex = 0;

	const answer = document.getElementById('answer');
	answer.innerHTML = '';
	answer.lang = UI.state.target;

	UI.displayGuess(false);
};

UI.onKeyUp = function (event) {
	const keyCode = parseInt(event.keyCode);
	if (keyCode > 47 && keyCode < 58) {
		UI.test(keyCode - 48);
	} else if (keyCode > 95 && keyCode < 106) {
		UI.test(keyCode - 96);
	} else if (keyCode === 8 && UI.state.mode === 'math') {
		UI.backspace();
	}
};

UI.setLanguage = function () {
	if (UI.state.mode === 'match') {
		UI.state.source = document.getElementById('source').value;
		UI.state.target = document.getElementById('target').value;
	} else {
		UI.state.source = document.getElementById('lang-math').value;
		UI.state.target = document.getElementById('lang-math').value;
	}
	UI.setQuery();
	UI.fillButtons();
	UI.next();
};

UI.setMode = function () {
	Tools.removeClass(document.body, UI.state.mode);
	UI.state.mode = document.getElementById('mode').value;
	UI.setLanguage();
	UI.setQuery();
	Tools.addClass(document.body, UI.state.mode);
	UI.next();
};

UI.setQuery = function () {
	const queryString = window.location.search;
	const urlParams = new URLSearchParams(queryString);
	urlParams.set('mode', UI.state.mode);
	if (UI.state.mode === 'match') {
		urlParams.set('source', UI.state.source);
		urlParams.set('target', UI.state.target);
	} else {
		urlParams.delete('source');
		urlParams.delete('target');
	}

	if (UI.state.mode === 'math') {
		urlParams.set('lang', UI.state.source);
	} else {
		urlParams.delete('lang');
	}
	var newRelativePathQuery = window.location.pathname + '?' + urlParams.toString();
	history.pushState(null, '', newRelativePathQuery);
};

UI.start = function () {
	const queryString = window.location.search;
	const urlParams = new URLSearchParams(queryString);
	if (UI.possibleModes.includes(urlParams.get('mode'))) {
		UI.state.mode = urlParams.get('mode');
	}

	if (UI.state.mode === 'match') {
		if (UI.possibleLanguages.includes(urlParams.get('source'))) {
			UI.state.source = urlParams.get('source');
		}
		if (UI.possibleLanguages.includes(urlParams.get('target'))) {
			UI.state.target = urlParams.get('target');
		}
	} else {
		if (UI.possibleLanguages.includes(urlParams.get('lang'))) {
			UI.state.source = urlParams.get('lang');
			UI.state.target = urlParams.get('lang');
		}
	}
	
	document.getElementById('source').value = UI.state.source;
	if (UI.state.mode !== 'math') {
		document.getElementById('target').value = UI.state.target;
	}
	document.getElementById('mode').value = UI.state.mode;
	UI.setMode();
	UI.setLanguage();
	UI.fillButtons();
	UI.next();
};

UI.test = function(n) {
	if (UI.state.mode === 'match') {
		UI.testMatch(n);
	} else {
		UI.testMath(n);
	}
};

UI.testMatch = function (n) {
	const step = document.getElementById(`s${UI.state.testIndex}`);
	step.textContent = Tools.getDigitsInLanguage(UI.state.target, [n])[0];
	if (n === UI.state.current[UI.state.testIndex]) {
		Tools.addClass(step, 'correct');
		Tools.removeClass(step, 'incorrect');
		UI.state.testIndex++;
		if (UI.state.testIndex === UI.state.current.length) {
			setTimeout(function() {
				UI.next();
			}, 500);
		}
	} else {
		Tools.removeClass(step, 'correct');
		Tools.addClass(step, 'incorrect');
	}
};

UI.testMath = function(n) {
	UI.state.guess.push(n);
	const isCorrect = UI.state.guess.join('') === UI.state.current.join('');
	UI.displayGuess(isCorrect);
	if (isCorrect) {
		setTimeout(function() {
			UI.next();
		}, 500);
	}
};

UI.displayGuess = function(isCorrect) {
	const className = isCorrect ? 'correct' : 'incorrect';
	const answer = document.getElementById('answer');
	answer.innerHTML = '';
	answer.lang = UI.state.source;
	for (let i = 0, ilen = UI.state.guessWidth - UI.state.guess.length; i < ilen; i++) {
		UI.addStep(answer, '&nbsp;');
	}
	for (let i = 0; i < UI.state.guess.length; i++) {
		UI.addStep(
			answer,
			Tools.getDigitsInLanguage(UI.state.source, [UI.state.guess[i]]),
			null,
			className
		);
	}
};
