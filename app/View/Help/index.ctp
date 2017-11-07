<h1 id="getting-started">Getting Started</h1>
<p>ARCS, or Archaeological Resource Cataloguing System, is a dynamic and
interactive ecosystem, which highlights both archival data and the physical
relationships between resources. </p>
<p>ARCS is an open-source web platform that enables individuals to collaborate in
creating and relating digitized primary evidence when conducting research in
the humanities. While ARCS certainly excels at storing and archiving data, it’s
real strength lies in its attention to the relationships your resources share
between themselves—and the people that created those resources. The other main
highlight of ARCS lies in its crowd-based model of data input and data
validation.</p>
<p>Using ARCS, you can retrieve resources using the search facility with the use
of simplified facets. Registered users of ARCS can interact with your research
collection in a number of different ways. They can create new resources, curate
targeted research collections, add resource annotations, review detailed
information about a resource or certain types of collections, and flag data
they deem to be problematic.</p>
<h2 id="resources">Resources</h2>
<p>A resource can be any form of digital data related to a research that a
researcher is working on. It can be photographs, page spreads, inventory cards,
maps, artifacts, reports, word documents, notebooks etc. You can learn more
details at the <a href="about-resources">Resources</a> section. </p>
<h2 id="annotation">Annotation</h2>
<p>An annotation is a short explanatory note made by any researcher and they can
be added by researchers to any resource when they are open to them. You can
learn more details at the <a href="annotating">Annotation</a> section.</p>
<h2 id="collections">Collections</h2>
<p>A collection can be formed by combining any form of the above mentioned
resources relevant to a particular segment of a research. You can learn more
details at the <a href="about-collections">Collections</a> section.</p>
<h2 id="uploading">Uploading</h2>
<p>Resources can be uploaded in ARCS in a very user-friendly manner. A researcher
can upload multiple files of different formats at a time. You can learn more
details at the <a href="Uploading">Uploading</a> section.</p>
<h2 id="searching">Searching</h2>
<p style="white-space:pre">While the ARCS system encourages browsing the resources uploaded by one or more projects, searching is often an effective way to identify resources individually or by type.  ARCS offers two different ways to search.

KEYWORD SEARCH

For those seeking to gain a more general sense of the resources within a project or across projects, a Keyword Search is recommended.

Keyword Searches query only 13 of all the possible fields that describe resources in the ARCS system.  They are as follows.

RESOURCE SCHEME -- focuses on 1 archival Resource (document, map, photograph, etc.) created during the archaeological field research process
Resource Title
Resource Identifier
Resource Type
Earliest Date of Resource
Latest Date of Resource
Accession/Catalog Number(s)

SUBJECT OF OBSERVATION SCHEME -- focuses on the archeological item that is the topic of study in the archival document
Artifact / Structure Classification
Artifact / Structure Type
Artifact / Structure Material
Manufacturing Technique
Artifact / Structure Period
Earliest Possible Date of Artifact / Structure
Latest Possible Date of Artifact / Structure

Searches involving lists or terms will generate results only all when all terms are present among these fields.  For example, a search for “Roman lamp” will return records where both "Roman" AND "lamp" appear in the Resource Title OR Resource Identifier OR Artifact / Structure Type OR Artifact / Structure Period, etc.

To search dates, enter the data as follows:
Complete year (e.g. 1972 and not 72)
Month and year (e.g. March 1972 and not 3/1972)
Full date in year, month, day format (e.g. 1972/03/15 and not 3/15/72)

Results of a Keyword search can be filtered according to Season, Resource Type, Excavation Units and Creator.  For specific definitions of these expressions, consult the ARCSCore Metadata Scheme.

Note too that searching across projects in ARCS is currently only possible by means of a Keyword Search.


ADVANCED SEARCH

For more specific searches for individual items or terms within a specific field, an Advanced Search can be useful.

Here searchable fields more closely match the complete number of fields in the ARCSCore <a href="#" id="advancedSearch" >metadata schema</a>.

Where possible, all existing terms in a field have been provided as a list of options.

Advanced Search fields are as follows

* Indicates fields that are populated automatically.

SEASON -- focuses on the period of time (season/campaign) during which archaeological research was conducted
Title
Research Activity*
Director(s)*

EXCAVATION SURVEY -- focuses on 1 field data collection unit when archaeological research was conducted
Unit of Study
Type of Study*
Supervisor(s)*

RESOURCE -- focuses on 1 archival Resource (document, map, photograph, etc.) created during the archaeological field research process
Resource Identifier
Resource Type*
Resource Title
Author/Creator*
Author/Creator Role*
Earliest Date of Resource*
Latest Date of Resource*
Language(s)*
Transcription

PAGES -- focuses on a single scanned page of the digitized archival document
Type*
Date Resource Scanned*
Creator of Scanned Resource

SUBJECT OF OBSERVATION GENERAL -- focuses on the archeological item that is the topic of study in the archival document
Artifact / Structure Classification*
Artifact / Structure Type*
Artifact / Structure Material*
Manufacturing Technique*
Artifact / Structure Period*
Earliest Possible Date of Artifact / Structure*
Latest Possible Date of Artifact / Structure*

SUBJECT OF OBSERVATION DETAILED -- focuses on the archeological item that is the topic of study in the archival document
Artifact / Structure Survey / Excavation Unit*
Project Specific Location*
Artifact / Structure Inscription

Because the Advanced Search requires search terms to be entered in a specific data field, searches involving lists of terms will generate results only when all terms are present in each specific field and NOT among fields. For example, a search for "Roman Lamp" in the Resource Title field will only return records where both "Roman" AND "lamp" appear in the Resource Title, regardless of their presence in other fields. Searches for terms in two different fields will generate results only when the unique search term is present in BOTH fields. For example, a search for "Roman lamp" in the Resource Title field and "lamp" in the Artifact / Structure Type field will only return records where "Roman" AND "lamp" are both in the Resource Title AND "lamp" is in the Artifact / Structure Type.
</p>



<script type="text/javascript">
    $(document).ready(function() {
      var baseURL = window.location.href.split("/help")[0];
        $("#advancedSearch").click(function() {
            window.location.href =
          baseURL + "/search/advanced/isthmia/"//only goes to isthmia right now
        })
    });
</script>
