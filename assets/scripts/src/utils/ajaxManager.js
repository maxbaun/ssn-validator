export default class AjaxManger {
	constructor(callback) {
		this.requests = [];
		this.completedRequests = [];
		this.callback = callback;
	}

	addRequest(options) {
		this.requests.push(options);
	}

	removeRequest(options) {
		if (jQuery.inArray(options, this.requests) > -1) {
			this.requests.splice(jQuery.inArray(options, this.requests), 1);
		}
	}

	run() {
		let oriSuc;

		if (this.requests.length) {
			oriSuc = this.requests[0].complete;

			this.requests[0].complete = this.complete(oriSuc).bind(this);
			jQuery.ajax(this.requests[0]);
		} else {
			this.tid = this.setTimer(this);
		}
	}

	complete(oriSuc) {
		return response => {
			if (typeof oriSuc === 'function') {
				oriSuc();
			}

			this.requests.shift();

			this.completedRequests.push(response);
			const progress = this.completedRequests.length / (this.requests.length + this.completedRequests.length) * 100;

			this.callback(progress);
			this.run();
		};
	}

	setTimer(self) {
		return setTimeout(() => {
			self.run();
		}, 1000);
	}

	stop() {
		this.requests = [];
		clearTimeout(this.tid);
	}
}
