<?php
/*
 * Copyright (c) 2015, 2020 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

interface VarType {
    const VAR_TYPE_INT = 0;
    const VAR_TYPE_POSITIVE_INT = 1;
    const VAR_TYPE_NEGATIVE_INT = 2;
    const VAR_TYPE_NON_NEGATIVE_INT = 3;
    const VAR_TYPE_NON_POSITIVE_INT = 4;
    const VAR_TYPE_FLOAT = 10;
    const VAR_TYPE_DOUBLE = 20;
    const VAR_TYPE_LONG = 30;
    const VAR_TYPE_BOOL = 50;
    const VAR_TYPE_STR = 100;
    const VAR_TYPE_NON_EMPTY_STR = 101;
    const VAR_TYPE_OBJECT = 200;
    const VAR_TYPE_ARRAY = 300;
}
