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

/**
 * The "forwardingRules" collection of methods.
 * Typical usage is:
 *  <code>
 *   $computeService = new Google_Service_Compute(...);
 *   $forwardingRules = $computeService->forwardingRules;
 *  </code>
 */
class Google_Service_Compute_Resource_ForwardingRules extends Google_Service_Resource
{
  /**
   * Retrieves an aggregated list of forwarding rules.
   * (forwardingRules.aggregatedList)
   *
   * @param string $project Project ID for this request.
   * @param array $optParams Optional parameters.
   *
   * @opt_param string filter Sets a filter expression for filtering listed
   * resources, in the form filter={expression}. Your {expression} must be in the
   * format: field_name comparison_string literal_string.
   *
   * The field_name is the name of the field you want to compare. Only atomic
   * field types are supported (string, number, boolean). The comparison_string
   * must be either eq (equals) or ne (not equals). The literal_string is the
   * string value to filter to. The literal value must be valid for the type of
   * field you are filtering by (string, number, boolean). For string fields, the
   * literal value is interpreted as a regular expression using RE2 syntax. The
   * literal value must match the entire field.
   *
   * For example, to filter for instances that do not have a name of example-
   * instance, you would use filter=name ne example-instance.
   *
   * You can filter on nested fields. For example, you could filter on instances
   * that have set the scheduling.automaticRestart field to true. Use filtering on
   * nested fields to take advantage of labels to organize and search for results
   * based on label values.
   *
   * To filter on multiple expressions, provide each separate expression within
   * parentheses. For example, (scheduling.automaticRestart eq true) (zone eq us-
   * central1-f). Multiple expressions are treated as AND expressions, meaning
   * that resources must match all expressions to pass the filters.
   * @opt_param string maxResults The maximum number of results per page that
   * should be returned. If the number of available results is larger than
   * maxResults, Compute Engine returns a nextPageToken that can be used to get
   * the next page of results in subsequent list requests. Acceptable values are 0
   * to 500, inclusive. (Default: 500)
   * @opt_param string orderBy Sorts list results by a certain order. By default,
   * results are returned in alphanumerical order based on the resource name.
   *
   * You can also sort results in descending order based on the creation timestamp
   * using orderBy="creationTimestamp desc". This sorts results based on the
   * creationTimestamp field in reverse chronological order (newest result first).
   * Use this to sort resources like operations so that the newest operation is
   * returned first.
   *
   * Currently, only sorting by name or creationTimestamp desc is supported.
   * @opt_param string pageToken Specifies a page token to use. Set pageToken to
   * the nextPageToken returned by a previous list request to get the next page of
   * results.
   * @return Google_Service_Compute_ForwardingRuleAggregatedList
   */
  public function aggregatedList($project, $optParams = array())
  {
    $params = array('project' => $project);
    $params = array_merge($params, $optParams);
    return $this->call('aggregatedList', array($params), "Google_Service_Compute_ForwardingRuleAggregatedList");
  }
  /**
   * Deletes the specified ForwardingRule resource. (forwardingRules.delete)
   *
   * @param string $project Project ID for this request.
   * @param string $region Name of the region scoping this request.
   * @param string $forwardingRule Name of the ForwardingRule resource to delete.
   * @param array $optParams Optional parameters.
   * @return Google_Service_Compute_Operation
   */
  public function delete($project, $region, $forwardingRule, $optParams = array())
  {
    $params = array('project' => $project, 'region' => $region, 'forwardingRule' => $forwardingRule);
    $params = array_merge($params, $optParams);
    return $this->call('delete', array($params), "Google_Service_Compute_Operation");
  }
  /**
   * Returns the specified ForwardingRule resource. (forwardingRules.get)
   *
   * @param string $project Project ID for this request.
   * @param string $region Name of the region scoping this request.
   * @param string $forwardingRule Name of the ForwardingRule resource to return.
   * @param array $optParams Optional parameters.
   * @return Google_Service_Compute_ForwardingRule
   */
  public function get($project, $region, $forwardingRule, $optParams = array())
  {
    $params = array('project' => $project, 'region' => $region, 'forwardingRule' => $forwardingRule);
    $params = array_merge($params, $optParams);
    return $this->call('get', array($params), "Google_Service_Compute_ForwardingRule");
  }
  /**
   * Creates a ForwardingRule resource in the specified project and region using
   * the data included in the request. (forwardingRules.insert)
   *
   * @param string $project Project ID for this request.
   * @param string $region Name of the region scoping this request.
   * @param Google_Service_Compute_ForwardingRule $postBody
   * @param array $optParams Optional parameters.
   * @return Google_Service_Compute_Operation
   */
  public function insert($project, $region, Google_Service_Compute_ForwardingRule $postBody, $optParams = array())
  {
    $params = array('project' => $project, 'region' => $region, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('insert', array($params), "Google_Service_Compute_Operation");
  }
  /**
   * Retrieves a list of ForwardingRule resources available to the specified
   * project and region. (forwardingRules.listForwardingRules)
   *
   * @param string $project Project ID for this request.
   * @param string $region Name of the region scoping this request.
   * @param array $optParams Optional parameters.
   *
   * @opt_param string filter Sets a filter expression for filtering listed
   * resources, in the form filter={expression}. Your {expression} must be in the
   * format: field_name comparison_string literal_string.
   *
   * The field_name is the name of the field you want to compare. Only atomic
   * field types are supported (string, number, boolean). The comparison_string
   * must be either eq (equals) or ne (not equals). The literal_string is the
   * string value to filter to. The literal value must be valid for the type of
   * field you are filtering by (string, number, boolean). For string fields, the
   * literal value is interpreted as a regular expression using RE2 syntax. The
   * literal value must match the entire field.
   *
   * For example, to filter for instances that do not have a name of example-
   * instance, you would use filter=name ne example-instance.
   *
   * You can filter on nested fields. For example, you could filter on instances
   * that have set the scheduling.automaticRestart field to true. Use filtering on
   * nested fields to take advantage of labels to organize and search for results
   * based on label values.
   *
   * To filter on multiple expressions, provide each separate expression within
   * parentheses. For example, (scheduling.automaticRestart eq true) (zone eq us-
   * central1-f). Multiple expressions are treated as AND expressions, meaning
   * that resources must match all expressions to pass the filters.
   * @opt_param string maxResults The maximum number of results per page that
   * should be returned. If the number of available results is larger than
   * maxResults, Compute Engine returns a nextPageToken that can be used to get
   * the next page of results in subsequent list requests. Acceptable values are 0
   * to 500, inclusive. (Default: 500)
   * @opt_param string orderBy Sorts list results by a certain order. By default,
   * results are returned in alphanumerical order based on the resource name.
   *
   * You can also sort results in descending order based on the creation timestamp
   * using orderBy="creationTimestamp desc". This sorts results based on the
   * creationTimestamp field in reverse chronological order (newest result first).
   * Use this to sort resources like operations so that the newest operation is
   * returned first.
   *
   * Currently, only sorting by name or creationTimestamp desc is supported.
   * @opt_param string pageToken Specifies a page token to use. Set pageToken to
   * the nextPageToken returned by a previous list request to get the next page of
   * results.
   * @return Google_Service_Compute_ForwardingRuleList
   */
  public function listForwardingRules($project, $region, $optParams = array())
  {
    $params = array('project' => $project, 'region' => $region);
    $params = array_merge($params, $optParams);
    return $this->call('list', array($params), "Google_Service_Compute_ForwardingRuleList");
  }
  /**
   * Changes target URL for forwarding rule. The new target should be of the same
   * type as the old target. (forwardingRules.setTarget)
   *
   * @param string $project Project ID for this request.
   * @param string $region Name of the region scoping this request.
   * @param string $forwardingRule Name of the ForwardingRule resource in which
   * target is to be set.
   * @param Google_Service_Compute_TargetReference $postBody
   * @param array $optParams Optional parameters.
   * @return Google_Service_Compute_Operation
   */
  public function setTarget($project, $region, $forwardingRule, Google_Service_Compute_TargetReference $postBody, $optParams = array())
  {
    $params = array('project' => $project, 'region' => $region, 'forwardingRule' => $forwardingRule, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('setTarget', array($params), "Google_Service_Compute_Operation");
  }
}
