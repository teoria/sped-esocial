<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../../../bootstrap.php';

use JsonSchema\Constraints\Constraint;
use JsonSchema\Constraints\Factory;
use JsonSchema\SchemaStorage;
use JsonSchema\Validator;

//S-2220 sem alterações da 2.4.1 => 2.4.2

$evento = 'evtMonit';
$version = '02_04_02';

$jsonSchema = '{
    "title": "evtMonit",
    "type": "object",
    "properties": {
        "sequencial": {
            "required": true,
            "type": "integer",
            "minimum": 1,
            "maximum": 99999
        },
        "indretif": {
            "required": true,
            "type": "integer",
            "minimum": 1,
            "maximum": 2
        },
        "idevinculo": {
            "required": true,
            "type": "object",
            "properties": {
                "cpftrab": {
                    "required": true,
                    "type": "string",
                    "maxLength": 11,
                    "minLength": 11
                },
                "nistrab": {
                    "required": true,
                    "type": "string",
                    "maxLength": 11,
                    "minLength": 11
                },
                "matricula": {
                    "required": true,
                    "type": "string",
                    "maxLength": 30
                }
            }
        },
        "aso": {
            "required": true,
            "type": "object",
            "properties": {
                "dtaso": {
                    "required": true,
                    "type": "string",
                    "pattern": "^(19[0-9][0-9]|2[0-9][0-9][0-9])[-/](0?[1-9]|1[0-2])[-/](0?[1-9]|[12][0-9]|3[01])$"
                },
                "tpaso": {
                     "required": true,
                     "type": "integer",
                     "minimum": 0,
                     "maximum": 8
                },
                "resaso": {
                     "required": true,
                     "type": "integer",
                     "minumum": 1,
                     "maximum": 2
                },
                "exame": {
                    "required": true,
                    "type": "array",
                    "minItems": 0,
                    "maxItems": 99,
                    "items": {
                        "type": "object",
                        "properties": {
                            "dtexm": {
                                "required": true,
                                "type": "string",
                                "pattern": "^(19[0-9][0-9]|2[0-9][0-9][0-9])[-/](0?[1-9]|1[0-2])[-/](0?[1-9]|[12][0-9]|3[01])$"
                            },
                            "procrealizado": {
                                "required": false,
                                "type": ["integer","null"],
                                "maximum": 99999999
                            },
                            "obsproc": {
                                "required": false,
                                "type": ["string","null"],
                                "maxLength": 200
                            },
                            "interprexm": {
                                "required": true,
                                "type": "integer",
                                "minimum": 1,
                                "maximum": 3
                            },
                            "ordexame": {
                                "required": true,
                                "type": "integer",
                                "minimum": 1,
                                "maximum": 2
                            },
                            "dtinimonit": {
                                "required": true,
                                "type": "string",
                                "pattern": "^(19[0-9][0-9]|2[0-9][0-9][0-9])[-/](0?[1-9]|1[0-2])[-/](0?[1-9]|[12][0-9]|3[01])$"
                            },
                            "dtfimmonit": {
                                "required": false,
                                "type": ["string","null"],
                                "pattern": "^(19[0-9][0-9]|2[0-9][0-9][0-9])[-/](0?[1-9]|1[0-2])[-/](0?[1-9]|[12][0-9]|3[01])$"
                            },
                            "indresult": {
                                "required": false,
                                "type": ["integer","null"],
                                "minimum": 1,
                                "maximum": 4
                            },
                            "respmonit": {
                                "required": true,
                                "type": "object",
                                "properties": {
                                    "nisresp": {
                                        "required": true,
                                        "type": "string",
                                        "minLength": 11,
                                        "maxLength": 11
                                    },
                                    "nrconsclasse": {
                                        "required": false,
                                        "type": ["string","null"],
                                        "maxLength": 8
                                    },
                                    "ufconsclasse": {
                                        "required": false,
                                        "type": ["string","null"],
                                        "maxLength": 2
                                    }
                                }
                            }    
                        }
                    }
                },
                "ideservsaude": {
                    "required": true,
                    "type": "object",
                    "properties": {
                        "codcnes": {
                            "required": false,
                            "type": ["string","null"],
                            "maxLength": 7
                        },
                        "frmctt": {
                            "required": true,
                            "type": "string",
                            "maxLength": 100
                        },
                        "email": {
                            "required": false,
                            "type": ["string","null"],
                            "maxLength": 60
                        },
                        "medico": {
                            "required": true,
                            "type": "object",
                            "properties": {
                                "nmmed": {
                                    "required": false,
                                    "type": ["string","null"],
                                    "maxLength": 70
                                },
                                "nrcrm": {
                                    "required": false,
                                    "type": ["string","null"],
                                    "maxLength": 8
                                },
                                "ufcrm": {
                                    "required": false,
                                    "type": ["string","null"],
                                    "maxLength": 2
                                }
                            }
                        }        
                    }
                }    
            }
        }    
    }
}';

$std = new \stdClass();
$std->sequencial = 1;
$std->indretif = 1;

$std->idevinculo = new \stdClass();
$std->idevinculo->cpftrab = '11111111111';
$std->idevinculo->nistrab = '11111111111';
$std->idevinculo->matricula = '11111111111';

$std->aso = new \stdClass();
$std->aso->dtaso = '2017-08-18';
$std->aso->tpaso = 0;
$std->aso->resaso = 1;

$std->aso->exame[0] = new \stdClass();
$std->aso->exame[0]->dtexm = '2017-08-18';
$std->aso->exame[0]->procrealizado = 10102019;
$std->aso->exame[0]->obsproc = 'observação do exame';
$std->aso->exame[0]->interprexm = 1;
$std->aso->exame[0]->ordexame = 1;
$std->aso->exame[0]->dtinimonit = '2017-08-18';
$std->aso->exame[0]->dtfimmonit = '2018-08-18';
$std->aso->exame[0]->indresult = 1;
$std->aso->exame[0]->respmonit = new \stdClass();
$std->aso->exame[0]->respmonit->nisresp = '11111111111';
$std->aso->exame[0]->respmonit->nrconsclasse = '11111111';

$std->aso->ideservsaude = new \stdClass();
$std->aso->ideservsaude->codcnes = '1111111';
$std->aso->ideservsaude->frmctt = 'CONTATO';
$std->aso->ideservsaude->email = 'teste@exemplo.com.br';
$std->aso->ideservsaude->medico = new \stdClass();
$std->aso->ideservsaude->medico->nmmed = 'NOME DO MEDICO';
$std->aso->ideservsaude->medico->nrcrm = '12345678';
$std->aso->ideservsaude->medico->ufcrm = 'SP';

// Schema must be decoded before it can be used for validation
$jsonSchemaObject = json_decode($jsonSchema);

// The SchemaStorage can resolve references, loading additional schemas from file as needed, etc.
$schemaStorage = new SchemaStorage();

// This does two things:
// 1) Mutates $jsonSchemaObject to normalize the references (to file://mySchema#/definitions/integerData, etc)
// 2) Tells $schemaStorage that references to file://mySchema... should be resolved by looking in $jsonSchemaObject
$schemaStorage->addSchema('file://mySchema', $jsonSchemaObject);

// Provide $schemaStorage to the Validator so that references can be resolved during validation
$jsonValidator = new Validator(new Factory($schemaStorage));

// Do validation (use isValid() and getErrors() to check the result)
$jsonValidator->validate(
        $std, $jsonSchemaObject, Constraint::CHECK_MODE_COERCE_TYPES  //tenta converter o dado no tipo indicado no schema
);

if ($jsonValidator->isValid()) {
    echo "The supplied JSON validates against the schema.<br/>";
} else {
    echo "JSON does not validate. Violations:<br/>";
    foreach ($jsonValidator->getErrors() as $error) {
        echo sprintf("[%s] %s<br/>", $error['property'], $error['message']);
    }
    die;
}
//salva se sucesso
file_put_contents("../../../jsonSchemes/v$version/$evento.schema", $jsonSchema);
