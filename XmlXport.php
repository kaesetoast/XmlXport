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
     * Constructor
     * 
     * @param mixed object or array containing the data
     */
    public function __construct($data) {
        $this->checkFormat($data);
        $this->data = $data;
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

    public function getAsXmlString() {
    }

}