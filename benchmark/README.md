# Benchmark

## Základní informace

- obsahuje kontejner s HTTP serverem pro následující technologie:
    - [PHP] - **Amphp**
    - [PHP] - **FrankenPHP**
    - [PHP] - **OpenSwoole**
    - [PHP] - **Swoole**
    - [PHP] - **ReactPHP**
    - [PHP] - **RoadRunner**
    - [PHP] - **Swow**
    - [PHP] - **Workerman**
    - [Go] - **valyala/fasthttp**
    - [JavaScript] - **hyper-express**
    - [Python] - **blacksheep**
- kontejner `benchmark_master` obsahuje:
    - 2 python skripty pro ovládání benchmarku
    - složku `benchmark_master/outputs` kde jsou uloženy JSON soubory s naměřenými výsledky
    - složku `benchmark_master/graphs` s vygenerovanými grafy
    - soubor `config.json`, kde lze nastavit:
        - počet opakování celého benchmarku (pokud je vyšší než 1, výsledky jsou zprůměrovány)
        - barevná schémata pro generování grafů
        - **parametry měření** (počet requestů, concurrency)
- **Upozornění:** výsledky benchmarku se mohou lišit v závislosti na hardware počítače, aktuálního vytížení systémových prostředků atd.

## Sestavení a spuštění prostředí
0) Nainstalovat Docker a Docker Compose
1) Přesunout se do adresáře benchmarku
2) Provést sestavení prostředí pomocí příkazu `docker-compose build`
3) Spustit prostředí pomocí příkazu `docker-compose up -d`
4) Pokud jsou všechny kontejnery úspěšně spuštěny, benchmark je připraven na použití


## Ovládání benchmarku
- je nutno spouštět Python skripty uvnitř běžícího kontejneru `benchmark_master`, čehož lze dosáhnout jednou z následujících možností:
    - použitím **GUI prostředí** (Docker Desktop), pomocí kterého lze vytvořit terminál uvnitř kontejneru
    - voláním příkazu [`docker exec`](https://docs.docker.com/reference/cli/docker/container/exec/) přímo z lokálního prostředí (nutno doplnit ID běžícího kontejneru)
- pro oba příkazy si lze zobrazit nápovědu zavoláním s parametrem `--help`

___

### Příkaz pro spuštění benchmarku
- načte parametry z konfiguračního souboru a spustí benchmark
```bash
python benchmark.py
```
- lze specifikovat benchmarkované služby, defaultně jsou zahrnuty všechny
___
- **Příklad** - Spuštění benchmarku se zahrnutím pouze PHP technologií
```bash
python benchmark.py --service openswoole --service swoole --service reactphp --service roadrunner --service amphp --service frankenphp --service swow --service workerman
```
- benchmark může trvat jednotky až desítky minut (dle počtu zahrnutých technologií a počtu opakování)
- výsledky měření se průběžně ukládají do složky `benchmark_master/outputs`
    - JSON soubory s výsledky mají formát:
        - `<název_technologie>-<concurrency>-<počet_requestů>.json`

___

### Příkaz pro vizualizaci výsledků
- vykreslí tabulku do console a vygeneruje grafy do složky `benchmark_master/graphs/graphs_<UNIX_timestamp>`
```bash
python visualise.py
```
- lze specifikovat služby, defaultně jsou zahrnuty všechny
- lze specifikovat barevné schéma grafů, defaultní je `color_warm`
- lze voláním také smazat staré vygenerované grafy, pomocí boolean parametru `clear_graphs`, defaultní je False
___
- **Příklad** - Vizualizace výsledku dvou PHP technologií s barevným schématem `color_cold`
```bash
python visualise.py --service swoole --service openswoole --color-scheme="color_cold"
```

# Ukázkový průběh benchmarku
- zde je popsán průběh benchmarku, který byl použit v rámci práce
- předpokládá se, že prostředí je spuštěno dle předchozího návodu

___

1. Benchmark je spuštěn pro všechny služby (defaultní nastavení)
```
python benchmark.py
```
2. První grafy jsou vygenerovány pouze pro PHP služby + staré grafy ze složky jsou smazány
```
python visualise.py True --service openswoole --service swoole --service reactphp --service roadrunner --service amphp --service frankenphp --service swow --service workerman --color-scheme="color_warm"
```

3. Další grafy jsou vygenerovány pouze pro Swoole a ostatní programovací jazyky + je použito jiné barevné schéma
```
python visualise.py --service swoole --service python --service nodejs --service golang --color-scheme="color_cold"
```