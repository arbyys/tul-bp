const { Server } = require('hyper-express');

const webserver = new Server();

const reqHandler = (request, response) => {
    response.json({  
        "version": process.version,
        "name": "Node.js (hyper-express)",
        "timestamp": Math.floor(Date.now() / 1000)
    });
  };
  
webserver.get("/", reqHandler);

const PORT = 8003;
const HOST = "0.0.0.0";
webserver.listen(PORT, HOST, () => {
    console.log(`Server running on port ${PORT}`);
}); 