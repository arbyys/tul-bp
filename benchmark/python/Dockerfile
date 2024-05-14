FROM python:3.9-slim

WORKDIR /app

RUN pip install blacksheep uvicorn

COPY /src .

RUN export PYTHONDONTWRITEBYTECODE=1

CMD ["uvicorn", "app:app", "--port", "8003", "--host", "0.0.0.0"]
