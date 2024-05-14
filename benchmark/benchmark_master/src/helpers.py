import shutil
import os
import json
import sys
from src.constants import ProcessMode, COMMAND, CONFIG_PATH

sys.dont_write_bytecode = True

# mode == DIRECTORIES:
#   delete all top-level directories (and their content) in given path, do not delete top-level files
# mode == FILES:
#   delete all top-level files in given path
def remove_items(path, mode=ProcessMode.DIRECTORIES, extensions=None):
    match mode:
        case ProcessMode.DIRECTORIES:
            for folder in os.listdir(path):
                new_path = os.path.join(path, folder)
                if os.path.isdir(new_path):
                    shutil.rmtree(new_path)

        case ProcessMode.FILES:
            for file in os.listdir(path):
                new_path = os.path.join(path, file)
                extension_matched = True if (extensions is None) else (new_path.endswith(tuple(extensions)))
                if os.path.isfile(new_path) and extension_matched:
                    os.remove(new_path)

# apply parameters to a command
def get_command(service, port, concurrency, requests):
    return COMMAND.format(concurrency, requests, service, port)

# config load from .json file
def load_config():
    with open(CONFIG_PATH, "r") as f:
        return json.load(f)