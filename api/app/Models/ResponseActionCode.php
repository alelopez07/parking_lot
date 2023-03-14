<?php

namespace App\Models;

enum ResponseActionCode {
    case CREATED;
    case UPDATED;
    case REMOVED;
}