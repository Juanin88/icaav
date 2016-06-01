module.exports = function(server) {
	var io = require('socket.io')(server);

	io.on('connection', function(socket) {
		socket.on('corporativo_created', function(message) {
			io.emit('corporativo_created', {});
		});

		socket.on('corporativo_edited', function(message) {
			io.emit('corporativo_edited', {});
		});

		socket.on('corporativo_deleted', function(message) {
			io.emit('corporativo_deleted', {});
		});

	});

};