<?php

  namespace arcs;

  use \Exception;

  interface ArcsErrors {
    /* Protected methods inherited from Exception class */
    public function getMessage();                 // Exception message
    public function getCode();                    // User-defined Exception code
    public function getFile();                    // Source filename
    public function getLine();                    // Source line
    public function getTrace();                   // An array of the backtrace()
    public function getTraceAsString();           // Formated string of trace
  }
  abstract class ErrorCodes {
    //bootstrap invalid config errors
    const ProjectPIDArrayNotFound    =  444000;
    const ProjectSIDArrayNotFound    =  444001;
    const SeasonSIDArrayNotFound     =  444002;
    const SurveySIDArrayNotFound     =  444003;
    const ResourceSIDArrayNotFound   =  444004;
    const PageSIDArrayNotFound       =  444005;
    const SubjectSIDArrayNotFound    =  444006;
    const TokenArrayNotFound         =  444007;

    //bootstrap missing data Error
    const ProjectPIDNotFound         =  444009;
    const ProjectSIDNotFound         =  444010;
    const SeasonSIDNotFound          =  444011;
    const SurveySIDNotFound          =  444012;
    const ResourceSIDNotFound        =  444013;
    const PageSIDNotFound            =  444014;
    const SubjectSIDNotFound         =  444015;
    const TokenNotFound              =  444016;
    const ProjectNameNotFound        =  444017;
  }
  class ArcsException extends Exception implements ArcsErrors {
    public function getArcsMessage()
    {
      $code = (int)($this->message);
      $message;
      switch ($code) {
        case ErrorCodes::ProjectPIDArrayNotFound:
          $message = "Missing the global project array.".
          "Please check your bootstrap file";
          break;

        default:
          # code...
          break;
      }
      return $message;
    }
  }
