<?php
/**
 * Simple util class wich creates XML objects from an given PHP Object or array
 * 
 * @author Philipp Nowinski <philipp@nowinski.de>
 */
class XmlXport {

    private $data;
    /**
     * list of supported input formats
     */
    private $supportedFormats = array(
        'array',
        'object'
    );
    /**
     * The format of the current input data
     */
    private $format;

    /**
     * The xml string
     */
    private $xml;

    /**
     * Constructor
     * 
     * @param mixed object or array containing the data
     * @param string optional xml header
     */
    public function __construct($data, $xmlHeader = '<?xml version="1.0" encoding="utf-8"?>') {
        $this->checkFormat($data);
        $this->data = $data;
        $this->xml = $xmlHeader;
    }

    /**
     * This function checks and stores the format of the given input data.
     * It throws an exception if data comes in unexpected formats.
     * As this class currently only supports objects and arrays, checking the type does the job.
     * For other formats (e.g. json), some more advanced tests would be necessary.
     * 
     * @param $data the given input data
     */
    private function checkFormat($data) {
        $type = gettype($data);
        if (in_array($type, $this->supportedFormats)) {
            $this->format = $type;
        } else {
            throw new InvalidArgumentException("The given format is currently not supported.");
        }
    }

    public function getString() {
        header ("Content-Type:text/xml");
        echo $this->xml . '<dataobject>' . $this->parseData($this->data) . '</dataobject>';
    }

    private function parseData($data) {
        $xml = '';
        foreach ($data as $key => $value) {
            if (is_array($value) || is_object($value)) {
                $xml .= '<' . $key . '>' . $this->parseData($value) . '</' . $key . '>';
            } else {
                $xml .= '<' . $key . '>' . $value . '</' . $key . '>';
            }
        }
        return $xml;
    }

}