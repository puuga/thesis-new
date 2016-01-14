// var app = require('express')();
// var http = require('http').Server(app);

var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);

// app.get('/', function(req, res){
//   res.send('<h1>Hello world</h1>');
//   console.log('incoming...');
// });

app.get('/', function(req, res) {
  res.sendFile(__dirname + '/monitor.html');
  // console.log(req);
});

app.get('/monitor', function(req, res) {
  io.emit('monitor_message_content_id_'+req.query.content_id, req.query);
  var returnData = {message:"ok"};
  res.send(returnData);
});

io.on('connection', function(socket){
  console.log('a user connected');

  socket.on('monitor_message', function(msg){
    console.log('message: ' + msg);
    io.emit('monitor_message', msg);
  });

  socket.on('disconnect', function(){
    console.log('user disconnected');
  });
});

http.listen(8081, function(){
  console.log('listening on *:8081');
});
