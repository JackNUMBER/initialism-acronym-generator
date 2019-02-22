# Initialism and Acronym Generator

The purpose of this tool is to create an [Algolia Synonyms](https://www.algolia.com/doc/guides/managing-results/optimize-search-results/adding-synonyms/how-to/managing-synonyms-from-the-dashboard/#importing-synonyms-from-a-file) JSON file by generating initialisms from a list of names.

In other words it generates alternatives names for a string. Otherwise it will not generates acronyms like *Benelux*.
You can see script limitations with the sample.

Roman numerals generates a variant with Arabic numbers.

## How to use
You can edit settings at the start of the **initialism.php** file and edit the `sample.txt`, and then run the script in CLI:
```
php initialism.php
```

## Sample

Input:
```
North Atlantic Treaty Organization
Joint Photographic Experts Group
structured query language
Grand Theft Auto V
NotAcronymizableString
compact disc read-only memory
light amplification by stimulated emission of radiation
```

Output:
```
[
    {
        "type": "synonym",
        "synonyms": ["North Atlantic Treaty Organization", "NATO"]
    },
    {
        "type": "synonym",
        "synonyms": ["Joint Photographic Experts Group", "JPEG"]
    },
    {
        "type": "synonym",
        "synonyms": ["structured query language", "SQL"]
    },
    {
        "type": "synonym",
        "synonyms": ["Grand Theft Auto V", "GTA5", "GTAV"]
    },
    {
        "type": "synonym",
        "synonyms": ["compact disc read-only memory", "CDROM"]
    },
    {
        "type": "synonym",
        "synonyms": ["light amplification by stimulated emission of radiation", "LABSEOR"]
    }
]
```
