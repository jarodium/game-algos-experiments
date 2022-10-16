/* Polyfill indexOf. */
var indexOf;

if (typeof Array.prototype.indexOf === 'function') {
    indexOf = function (haystack, needle) {
        return haystack.indexOf(needle);
    };
} else {
    indexOf = function (haystack, needle) {
        var i = 0, length = haystack.length, idx = -1, found = false;

        while (i < length && !found) {
            if (haystack[i] === needle) {
                idx = i;
                found = true;
            }

            i++;
        }

        return idx;
    };
};


/* Polyfill EventEmitter. */
var EventEmitter = function () {
    this.events = {};
};

EventEmitter.prototype.on = function on( name, fn ) {
    this.events[name] = [fn].concat( this.events[name] || [] );
}

EventEmitter.prototype.removeListener = function (event, listener) {
    var idx;

    if (typeof this.events[event] === 'object') {
        idx = indexOf(this.events[event], listener);

        if (idx > -1) {
            this.events[event].splice(idx, 1);
        }
    }
};

EventEmitter.prototype.removeAllListeners = function removeAllListeners( name ) {
    if ( name ) {
        delete this.events[name];
    } else {
        // drop the old reference
        this.events = {};
    }
}

EventEmitter.prototype.emit = function emit( name, data ) {
    for ( let i = this.events[name].length - 1; i >= 0 ; --i ) {
        this.events[name][i]( data );
    }
}

EventEmitter.prototype.once = function (event, listener) {
    this.on(event, function g () {
        this.removeListener(event, g);
        listener.apply(this, arguments);
    });
};