<?php
/*
 * Copyright 2016 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

class Google_Service_AdExchangeBuyer_DealServingMetadataDealPauseStatus extends Google_Model
{
  public $firstPausedBy;
  public $hasBuyerPaused;
  public $hasSellerPaused;

  public function setFirstPausedBy($firstPausedBy)
  {
    $this->firstPausedBy = $firstPausedBy;
  }
  public function getFirstPausedBy()
  {
    return $this->firstPausedBy;
  }
  public function setHasBuyerPaused($hasBuyerPaused)
  {
    $this->hasBuyerPaused = $hasBuyerPaused;
  }
  public function getHasBuyerPaused()
  {
    return $this->hasBuyerPaused;
  }
  public function setHasSellerPaused($hasSellerPaused)
  {
    $this->hasSellerPaused = $hasSellerPaused;
  }
  public function getHasSellerPaused()
  {
    return $this->hasSellerPaused;
  }
}
