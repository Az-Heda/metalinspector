#include <iostream>
#include <fstream>

using namespace std;

int main()
{
	bool rimani = true;
	int cid;
	string url;
	ofstream out;
	out.open("update.sql");
	do
	{
		cout <<"Inserisci l'ID della canzone: ";
		cin >>cid;
		if (cid > 0)
		{
			cout <<"Inserisci l'url del sito di lyrics: ";
			cin >> url;
			out <<"update canzoni set lyrics = '" <<url <<"' where canzone_id = " <<cid <<";" <<endl;
			system("cls");
		}
		else
		{
			rimani = false;
		}
	} while (rimani);
	out.close();
	return 0;
}
