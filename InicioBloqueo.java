package co.edu.procastinadont;

import android.app.ActivityManager;
import android.content.Context;
import android.content.pm.ApplicationInfo;
import android.content.pm.PackageManager;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.Toast;
import androidx.appcompat.app.AppCompatActivity;
import java.util.ArrayList;
import java.util.List;
import android.content.Intent;
import android.net.Uri;
import android.provider.Settings;

public class InicioBloqueo extends AppCompatActivity {

    private Spinner spinnerApps;
    private EditText editTextTiempo;
    private Button btnIniciarBloqueo;
    private List<ApplicationInfo > installedApps;
    private String selectedAppName;
    private int selectedTime;
    private static final int REQUEST_CODE_DRAW_OVERLAY = 1234;
    private static final String TAG = "Primero";



    @Override
    protected void onCreate(Bundle savedInstanceState) {

        if (!Settings.canDrawOverlays(this)) {
            Intent intent = new Intent(Settings.ACTION_MANAGE_OVERLAY_PERMISSION,
                    Uri.parse("package:" + getPackageName()));
            startActivityForResult(intent, REQUEST_CODE_DRAW_OVERLAY);
        } else {
            startService(new Intent(InicioBloqueo.this, BloqueoService.class));
        }
        super.onCreate(savedInstanceState);
        setContentView(R.layout.bloqueador);

        spinnerApps = findViewById(R.id.spinner_apps);
        editTextTiempo = findViewById(R.id.edit_text_tiempo);
        btnIniciarBloqueo = findViewById(R.id.boton_iniciar_bloqueo);

        installedApps = getAppsInstaladas();

        ArrayAdapter<String> adapter = new ArrayAdapter<>(this, android.R.layout.simple_spinner_dropdown_item, getNombreApps());
        spinnerApps.setAdapter(adapter);

        spinnerApps.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parentView, View selectedItemView, int position, long id) {
                selectedAppName = getPackageManager().getApplicationLabel(installedApps.get(position)).toString();
            }

            @Override
            public void onNothingSelected(AdapterView<?> parentView) {
            }
        });

        btnIniciarBloqueo.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (selectedAppName != null && !editTextTiempo.getText().toString().isEmpty()) {
                    selectedTime = Integer.parseInt(editTextTiempo.getText().toString());

                    String AppPrimero = Primero();

                    Intent intent = new Intent(InicioBloqueo.this, BloqueoService.class);
                    intent.putExtra("NombreApp", selectedAppName);
                    intent.putExtra("AppPrimerPlano", AppPrimero);
                    intent.putExtra("TiempoBloqueo", selectedTime);
                    startService(intent);

                    Toast.makeText(InicioBloqueo.this, "Iniciando bloqueo para " + selectedAppName + " durante " + selectedTime + " minutos", Toast.LENGTH_SHORT).show();
                } else {
                    Toast.makeText(InicioBloqueo.this, "Selecciona una aplicación y un tiempo válido", Toast.LENGTH_SHORT).show();
                }
            }
        });
        Primero();

    }


    private List<ApplicationInfo> getAppsInstaladas() {
        PackageManager packageManager = getPackageManager();
        return packageManager.getInstalledApplications(PackageManager.GET_META_DATA);
    }

    private List<String> getNombreApps() {
        List<String> appNames = new ArrayList<>();
        for (ApplicationInfo appInfo : installedApps) {
            appNames.add(appInfo.loadLabel(getPackageManager()).toString());
        }
        return appNames;
    }



    private String Primero() {
        ActivityManager activityManager = (ActivityManager) getSystemService(Context.ACTIVITY_SERVICE);
        List<ActivityManager.RunningAppProcessInfo> appProcesses = activityManager.getRunningAppProcesses();

        if (appProcesses != null && !appProcesses.isEmpty()) {
            PackageManager packageManager = getPackageManager();
            for (ActivityManager.RunningAppProcessInfo appProcess : appProcesses) {
                if (appProcess.importance == ActivityManager.RunningAppProcessInfo.IMPORTANCE_FOREGROUND) {
                    try {
                        ApplicationInfo appInfo = packageManager.getApplicationInfo(appProcess.processName, PackageManager.GET_META_DATA);
                        CharSequence appName = packageManager.getApplicationLabel(appInfo);
                        String AppPrimerPlano = appName.toString();
                        Log.d(TAG, "App en primer plano: " + AppPrimerPlano);
                        return AppPrimerPlano;
                    } catch (PackageManager.NameNotFoundException e) {
                        e.printStackTrace();
                    }
                }
            }
        }
        return null;
    }


}