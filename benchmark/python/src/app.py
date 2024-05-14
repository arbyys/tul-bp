from datetime import datetime
import sys
import blacksheep as bs

app = bs.Application()

@bs.get("/")
async def home():

    return bs.json({  
            "version": sys.version,
            "name": "Python (blacksheep)",
            "timestamp": int(datetime.now().timestamp())
        }
    )